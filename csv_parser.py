# necessary packages to be used
import csv

def main():
    # using csv and python methods to read and import the CSV file
    openCSV = open('rawdataedit.csv', 'r')
    csvHeader = csv.reader(openCSV)
    fileWrite = open('database_insert.sql', 'w')
    
    # Insert statement to be written and printed for assign2_dna_protein_table
    finalStatement = []
    insert = ''
    writer = ''
    
    # Basis of insert statements to be used for the database
    insertBase = 'INSERT INTO organism_info VALUES ('
    insertBase2 = 'INSERT INTO sequence_read VALUES('
    insertBase3 = 'INSERT INTO assembly VALUES ('
    i = 0
    row = next(csvHeader)
    for row in csvHeader:
        insertBase = insertBase + "'" + row[0] + "', '" + row[1] + "', '" + row[2] + "');" + "\n"
        insertBase2 = insertBase2 + "'" + row[3] + "', '" + row[1] + "');" + "\n"
        insertBase3 = insertBase3 + "'" + row[4] + "', '" + row[1] + "');" + "\n"

        fileWrite.write(insertBase)
        fileWrite.write(insertBase2)
        fileWrite.write(insertBase3)


        insertBase = 'INSERT INTO organism_info VALUES ('
        insertBase2 = 'INSERT INTO sequence_read VALUES('
        insertBase3 = 'INSERT INTO assembly VALUES ('
    

    # Properly closing file writers, csvHeader automatically closes.
    fileWrite.close()

if __name__ == '__main__':
    main()
