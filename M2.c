

///
/// Opens the specified file for use
///   R/W position is set to the beginning of the file (BOF)
///   Directories cannot be opened
/// \param fs The S16FS containing the file
/// \param path path to the requested file
/// \return file descriptor to the requested file, < 0 on error
///
int fs_open(S16FS_t *fs, const char *path);

///
/// Closes the given file descriptor
/// \param fs The S16FS containing the file
/// \param fd The file to close
/// \return 0 on success, < 0 on failure
///
int fs_close(S16FS_t *fs, int fd);

///
/// Moves the R/W position of the given descriptor to the given location
///   Files cannot be seeked past EOF or before BOF (beginning of file)
///   Seeking past EOF will seek to EOF, seeking before BOF will seek to BOF
/// \param fs The S16FS containing the file
/// \param fd The descriptor to seek
/// \param offset Desired offset relative to whence
/// \param whence Position from which offset is applied
/// \return offset from BOF, < 0 on error
///
off_t fs_seek(S16FS_t *fs, int fd, off_t offset, seek_t whence);

///
/// Reads data from the file linked to the given descriptor
///   Reading past EOF returns data up to EOF
///   R/W position in incremented by the number of bytes read
/// \param fs The S16FS containing the file
/// \param fd The file to read from
/// \param dst The buffer to write to
/// \param nbyte The number of bytes to read
/// \return number of bytes read (< nbyte IFF read passes EOF), < 0 on error
///
ssize_t fs_read(S16FS_t *fs, int fd, void *dst, size_t nbyte);

///
/// Writes data from given buffer to the file linked to the descriptor
///   Writing past EOF extends the file
///   Writing inside a file overwrites existing data
///   R/W position in incremented by the number of bytes written
/// \param fs The S16FS containing the file
/// \param fd The file to write to
/// \param dst The buffer to read from
/// \param nbyte The number of bytes to write
/// \return number of bytes written (< nbyte IFF out of space), < 0 on error
///
ssize_t fs_write(S16FS_t *fs, int fd, const void *src, size_t nbyte) {
	if(fs && bitmap_test(fs->fd_table.fd_status) && src && nbyte) {
		inode_ptr_t *f_inode = &fs->i_table[fs->fd_table.fd_inode[fd]];
		off_t offset = fs->fd_table.fd_pos[fd];
		size_t bytes_to_write = nbyte;
		size_t bytes_written = 0;
		size_t log_block_offset = offset / BLOCK_SIZE;
		size_t log_block_byte_offset = offset % BLOCK_SIZE;
		size_t log_block_bytes_left = BLOCK_SIZE - log_block_byte_offset + 1;
		uint8_t data[BLOCK_SIZE];
		block_ptr_t	i_block[BLOCK_SIZE / sizeof(block_ptr_t)];
		size_t blocks_to_write;

		if(bytes_to_write <= log_block_bytes_left) {
			blocks_to_write = 1;
			//get log_block_offset block

			memcpy(data[log_block_byte_offset], src, bytes_to_write);
			//write block back out
		} else {
			//blocks_to_write = log_block + additional full blocks
			blocks_to_write = 1 + (bytes_to_write - log_block_bytes_left) / BLOCK_SIZE;
			// + a block for partial block of data if needed
			if((bytes_to_write - log_block_bytes_left) % BLOCK_SIZE) {
				blocks_to_write++;
			}
		}

		block_ptr_t block_ptrs[blocks_to_write] = {0};
		for(size_t i = 0; i < blocks_to_write;) {
			if(log_block_offset + i < 6) {
				block_ptrs[i] = f_inode->blocks[log_block_offset + i];
				if(block_ptrs[i] == 0) {
					block_ptrs[i] = back_store_allocate(fs->bs);
				}
				i++;
			} else if(log_block_offset + i < 518) {

			} else if(log_block_offset + i < 262662) {

			}
		}
		//have list of blocks to write to

	} //else bad parameter
	return -1;
}

if(log_block_offset < 6) {
	//get direct block => block
	if(!back_store_read(fs->bs, f_inode->blocks[log_block_offset], data)) {
		return -1;
	}
} else if(log_block_offset < 518) {
	//get indrect block f_inode->blocks[6] => i_block
	if(!back_store_read(fs->bs, f_inode->blocks[6], i_block)) {
		return -1;
	}
	//get data block at i_block[log_block_offset - 6]
	if(!back_store_read(fs->bs, i_block[log_block_offset -6], data)) {
		return -1;
	}
} else if(log_block_offset < 262662) {
	//get double indirect block f_inode_blocks[7] => i_block
	if(!back_store_read(fs->bs, f_inode->blocks[7], i_block)) {
		return -1;
	}
	//figure out which indirect block to get
	i_block_idx = (log_block_offset - 518) / 512;
	//get indirect block d_block[i_block_idx] => i_block
	if(!back_store_read(fs->bs, i_block[i_block_idx], i_block)) {
		return -1;
	}
	//get data block at [log_block_offset - 518 - 512*i_block_idx] => block
	if(!back_store_read(fs->bs, i_block[log_block_offset - 518 - (512*i_block_idx)], data)) {
		return -1;
	}
}
//have the logical block in data

bool get_data_blocks(S16FS_t *fs, inode_ptr_t f_idx, inode_ptr_t *data) {
	inode_t *f_inode = &fs->i_table[f_idx];
	unsigned n_blocks = f_inode->mdata.i_blocks; //number of file blocks
	unsigned n_iblocks = 0; //number of blocks through single indirection
	unsigned n_diblocks = 0; //number of blocks through double indirection
	unsigned n_d_ind = 0; //number of indirect ptrs in double indirect block
	block_ptr_t i_block[BLOCK_SIZE / sizeof(block_ptr_t)] = {0};
	block_ptr_t d_block[BLOCK_SIZE / sizeof(block_ptr_t)] = {0};

	if(f_inode->blocks[6]) {
		n_iblocks = n_blocks - 6;
		if(!back_store_read(fs->bs, f_inode->blocks[7], i_block)) {
			return false;
		}
		if(f_inode->blocks[7]) {
			n_diblocks = n_blocks - 518;
			n_d_ind = n_diblocks / (BLOCK_SIZE/sizeof(block_ptr_t));
			if(!back_store_read(fs->bs, f_inode->blocks[8], d_block)) {
				return false;
			}
		}
	}
/*
	for(unsigned i = 0; i < n_blocks; i) {
		if(i < 6) {
			data[i] = f_inode->blocks[i];
			i++;
		} else if(i < 518) {
			for(unsigned j = 0; j < n_iblocks; j++) {
				data[i] = i_block[j];
				i++;
			}
		} else if(i < 262662) {
			for(unsigned k = 0; k < n_d_ind; k++) {
				if(!back_store_read(fs->bs, d_block[k], i_block)) {
					return false;
				}
				for(unsigned j = 0; i < n_blocks && j < n_diblocks && j < 512; j++) {
					data[i] = i_block[j];
					i++;
				}
				n_diblocks -= j;
			}
		} else {
			//something really bad happened, ABORT!
			return false;
		}
	}
*/

	for(unsigned i = 0; i < 6 && i < n_blocks; i++) {
		data[i] = f_inode->blocks[i];
	}

	if(f_inode->blocks[6]) {
		//get indirect block into i_block
		block_ptr_t i_block[512] = {0};
		if(!back_store_read(fs->bs, f_inode->blocks[6], i_block)) {
			return false;
		}
		for(unsigned i = 0; i < 512 && i < n_blocks; i++) {
			data[i+6] = i_block[i];
		}
	}

	return true;
}

///
/// Deletes the specified file and closes all open descriptors to the file
///   Directories can only be removed when empty
/// \param fs The S16FS containing the file
/// \param path Absolute path to file to remove
/// \return 0 on success, < 0 on error
///
int fs_remove(S16FS_t *fs, const char *path);
