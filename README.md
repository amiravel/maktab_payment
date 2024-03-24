## Step 1: Dump the Database
Use the following command to dump the database on the source server:
```bash
$ mysqldump -u [username] -p [database_name] > database_dump.sql
```

## Step 2: Import the Database
Transfer the database_dump.sql file to the new server and execute the following command to import the database:
```bash
$ mysql -u [username] -p [database_name] < database_dump.sql
```

## Step 3: Update Database Configuration
Open the .env file on the new server and update the database configuration with the appropriate values:

```
DB_HOST=[new_database_host]
DB_PORT=[new_database_port]
DB_NAME=[new_database_name]
DB_USER=[new_database_user]
DB_PASSWORD=[new_database_password]
```

## Step 4: Copy .env Content
Copy the remaining content of the .env file from the source server to the destination server.

## Step 5: Clone the Code
Clone the code repository on the new server using the following command:
```
git clone [repository_url]
```

## Step 6: Run Docker Compose
THIS PROJECT SERVE WITH traefik AND I DONT KNOW HOW SHOULD BEHAVE HERE. DISCOVER IT WITH YOURSELF


# TIP
panel_api project depends in this project