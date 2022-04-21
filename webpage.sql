/*
 *
 *  DDL for the creation of the E. COLI ANTIBIOTIC RESISTANT SEQUENCE READ ARCHIVE.
 *
 */



/*   
 *  The linchpin table. Prim Key is the isolate number, 
 *  strain indicates the named strain, and create data is the dat it was extracted
 */
create table organism_info(strain varchar(20), isolate varchar(20) not null, 
	create_date varchar(50), primary key (isolate));

/*
 *  A table that retains the bioproject ID for returning to NCBI. 
 */
create table sequence_read(sra_number varchar(20), isolate varchar(20), primary key (sra_number), 
	foreign key (isolate) references organism_info(isolate));

/*
 *  A table that retains the assembly ID for returning to NCBI.
 */
create table assembly(refseq_number varchar(20), isolate varchar(20), primary key(refseq_number), 
	foreign key (isolate) references organism_info(isolate));
