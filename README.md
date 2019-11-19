### Installation
 - clone repo
   ```
   git clone https://github.com/sam-lopata/epgimporter.git
   ```
 - create database and user
 
 - create config/config.yaml by copying provided config/config.yaml.dist and setting your parameters 
      
 - Run to install dependencies and initialize database 
   ```
   composer install
   ```
    
 If dependencies installed but then something went wrong try to install manually
 
 - create application DB tables
    ```
    bin/app orm:schema-tool:create
    ```
    
 - import initial data (channels and show_types)
    ```
    bin/app dbal:import src/Resources/initial-data.sql
    ```
    
 - After that can change dev_mode to false in config.yaml

### Usage
 - Sample file located at src/Resources/kuivuri.xml so easiest way to execute and test 
   ```
   bin/app importer:run --source=src/Resources/kuivuri.xml --format=xml
   ```
   
 - To see command help
   ```
   bin/app help importer:run 
   ```
    
 - To run tests
   ```
   vendor/bin/phpunit
   ```
  
  - Dry run to see results
    ```
    bin/app importer:run --source=src/Resources/kuivuri.xml --format=xml --dry-run
    ```
    
  - Example of usage different parser, in this case JSONParser(mocked for npw) will be used
    ```
    bin/app importer:run --source=src/Resources/anyfile --format=json --dry-run
    ```
 
### Difference from original DB structure
  - Moved show_type to 'service_livetv_show_type' table and made not optional, because of avoiding usage of ENUM type and db normalisation
  - Set service_livetv_channel DEFAULT CHARSET to utf8;
  - Removed TIMESTAMP fields (using datetime and doctrine timestampable extension])
  - Made ext_program_id nullable for now because can not find appropriative value in provided xml 

### Todo
Just a list of things would be good to implement
- Make installation script interactive 
- Add Logging
- Additional cache over doctrine's
- Not sure about if processing SPEED is good enough but in case some actionas could be taken:
    - use alternative (Symfony Configuration check or third party validator class) or disable xml validation - could give huge improvement
    - load file in memory instead of stream processing (XMLParsr::expand() is really costly function)
    - use direct SQL/DQL queries with multiple rows - could be an issue on really huge data
