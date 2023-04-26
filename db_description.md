Employee Management Database

This database models an Employee Management System. It consists of 4 tables in 3NF:

# Employees

Fields:

    EmployeeID (primary key)
    FirstName
    LastName
    Email (unique)
    Phone
    Address
    DepartmentID (foreign key)
    ManagerID
    HireDate
    Gender
    DateOfBirth

Functional dependencies (FDs):

    EmployeeID -> FirstName, LastName, Email, Phone, Address, DepartmentID, ManagerID, HireDate, Gender, DateOfBirth
    Email -> EmployeeID (assuming each email address is unique to a single employee)


Foreign key policy:

    On delete: Cascade (delete all employee records associated with the deleted department)
    On update: Cascade (update departmentID in all employee records associated with the updated department)

Trigger:
    Employees table trigger to enforce unique email addresses


Sample data:

| EmployeeID 	| FirstName 	| LastName 	| Email                   	| Phone        	| Address                       	| DepartmentID 	| ManagerID 	| HireDate   	| Gender 	| DateOfBirth 	|
|------------	|-----------	|----------	|-------------------------	|--------------	|-------------------------------	|--------------	|-----------	|------------	|--------	|-------------	|
| 1          	| John      	| Doe      	| johndoe@gmail.com       	| 1234567890 	| 123 Main St, New York, NY     	| 1            	|           	| 2021-01-01 	| M      	| 1990-01-01  	|
| 2          	| Jane      	| Smith    	| janesmith@gmail.com     	| 9876543210 	| 456 Maple St, Chicago, IL     	| 2            	| 1         	| 2021-01-15 	| F      	| 1995-03-12  	|
| 3          	| Bob       	| Johnson  	| bobjohnson@gmail.com    	| 5555555555 	| 789 Oak St, San Francisco, CA 	| 3            	| 1         	| 2021-02-01 	| M      	| 1985-07-06  	|
| 4          	| Alice     	| Williams 	| alicewilliams@gmail.com 	| 1112223333 	| 321 Pine St, Los Angeles, CA  	| 4            	| 1         	| 2021-02-15 	| F      	| 1992-11-22  	|
| 5          	| Tom       	| Lee      	| tomlee@gmail.com        	| 5551234567 	| 987 Elm St, Dallas, TX        	| 5            	| 1         	| 2021-03-01 	| M      	| 1998-04-18  	|

# Departments

Fields:

    DepartmentID (primary key)
    DepartmentName
    DepartmentLocation
    Budget

Functional dependencies (FDs):

    DepartmentID -> DepartmentName, DepartmentLocation, Budget


Foreign key policy:

    None

Trigger:

    None


Sample data:

| DepartmentID | DepartmentName  | DepartmentLocation | Budget    |
|--------------|-----------------|--------------------|-----------|
| 1            | Marketing       | New York           | 50000.00  |
| 2            | Human Resources | Chicago            | 75000.00  |
| 3            | IT              | San Francisco      | 100000.00 |
| 4            | Sales           | Los Angeles        | 90000.00  |
| 5            | Finance         | Dallas             | 80000.00  |

# Salaries

Fields:

    SalaryID (primary key)
    EmployeeID (foreign key)
    SalaryAmount
    StartDate
    EndDate
    PayType
    Currency


Functional dependencies (FDs):

    SalaryID -> EmployeeID, SalaryAmount, StartDate, EndDate, PayType, Currency
    EmployeeID, StartDate -> EndDate (assuming there is only one salary record per employee at any given time)


Foreign key policy:

    On delete: Cascade (delete all salary records associated with the deleted employee)
    On update: Cascade (update EmployeeID in all salary records associated with the updated employee)

Trigger:

    Salaries table trigger to ensure salary dates do not overlap for each employee


Sample data:
| SalaryID | EmployeeID | SalaryAmount | StartDate  | EndDate    | PayType | Currency |
|----------|------------|--------------|------------|------------|---------|----------|
| 1        | 1          | 60000        | 2020-01-01 | 2020-12-31 | Annual  | USD      |
| 2        | 1          | 70000        | 2021-01-01 | 2021-12-31 | Annual  | USD      |
| 3        | 2          | 80000        | 2018-06-01 | 2019-05-31 | Annual  | USD      |
| 4        | 2          | 90000        | 2019-06-01 | 2020-05-31 | Annual  | USD      |
| 5        | 2          | 100000       | 2020-06-01 | 2021-05-31 | Annual  | USD      |
| 6        | 2          | 110000       | 2021-06-01 | 2022-05-31 | Annual  | USD      |
| 7        | 3          | 75000        | 2019-03-15 | 2020-03-14 | Annual  | USD      |
| 8        | 3          | 80000        | 2020-03-15 | 2021-03-14 | Annual  | USD      |


# LeaveRequests

Fields:

    LeaveRequestID (primary key)
    EmployeeID (foreign key)
    StartDate
    EndDate
    RequestStatus

Functional dependencies (FDs):

    LeaveRequestID -> EmployeeID, StartDate, EndDate, RequestStatus

Foreign key policy:

    On delete: Cascade (delete all leave request records associated with the deleted employee)
    On update: Cascade (update EmployeeID in all leave request records associated with the updated employee)

Trigger:

    LeaveRequests table trigger to check valid request status for leave requests.

Sample data:

| LeaveRequestID | EmployeeID | StartDate  | EndDate    | RequestStatus |
|----------------|------------|------------|------------|---------------|
| 1              | 1          | 2022-06-01 | 2022-06-03 | Approved      |
| 2              | 2          | 2022-07-15 | 2022-07-22 | Pending       |
| 3              | 3          | 2022-08-01 | 2022-08-05 | Denied        |
| 4              | 4          | 2022-09-10 | 2022-09-15 | Approved      |
| 5              | 5          | 2022-10-20 | 2022-10-25 | Pending       |