import csv

input_file = '/Users/philipclarke/CMS375-Spring2024/databasestuff/rollins_activities_and_descriptions.csv'
output_file = 'clubsclean.php'
table_name = 'rollins_activities_and_descriptions'

with open(input_file, mode='r', encoding='utf-8') as infile, open(output_file, mode='w', encoding='utf-8') as outfile:
    reader = csv.reader(infile)
    next(reader)  # Skip the header row
    for row in reader:
        # Assuming two columns here; adjust as necessary.
        outfile.write(f"INSERT INTO {table_name} (ActivityName, Description) VALUES ('{row[0]}', '{row[1]}');\n")
