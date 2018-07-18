# Crossbeam Engineering Challenge

# Deliverables
Along with your code, send us instructions for executing it. Your code should reflect what we would expect from you when developing code for production.

# Solution

## Technology
 - PHP

## Scripts
 - crossbeam.class.php
 - curl.class.php
 - runner.php
 

## How to run script
 - Go to the directory from command line where script "runner.php" is located
 - Type "php runner.php {Argument1} {Argument1}"
 - Where {Argument1} and {Argument1} are the name of arguments/api-endpoints from which you want to fetch data.

## Example
 - php runner.php favorites search-engines

## Expected Output
### Success Scenario
 - Script should echo/output three digits separated by single space e.g. 3 6 1
### Failure Scenario
 - When not enough parameters are given then script should echo/output "Atleast two arguments needs to be passed"
 - When any of the API endpoint is not found "No valid response got from {API_URL}"
 - When companies data is not found "No companies found"



