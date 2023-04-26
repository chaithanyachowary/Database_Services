# CRUD operations for Departments table:

CREATE:
INSERT INTO Departments (DepartmentID, DepartmentName, DepartmentLocation, Budget)
VALUES (1, 'Human Resources', 'New York', 100000);

READ:
SELECT * FROM Departments;

UPDATE:
UPDATE Departments
SET Budget = 120000
WHERE DepartmentID = 1;

DELETE:
DELETE FROM Departments
WHERE DepartmentID = 1;

# CRUD operations for Employees table:

CREATE:
INSERT INTO Employees (EmployeeID, FirstName, LastName, Email, Phone, Address, DepartmentID)
VALUES (1, 'James', 'Potter', 'james@gmail.com', '5551234', '123 Main St', 1);

READ:
SELECT * FROM Employees;

UPDATE:
UPDATE Employees
SET DepartmentID = 2
WHERE EmployeeID = 1;


DELETE:
DELETE FROM Employees
WHERE EmployeeID = 1;


# CRUD operations for Salaries table:

CREATE:
INSERT INTO Salaries (SalaryID, EmployeeID, SalaryAmount, StartDate, EndDate, PayType, Currency)
VALUES (1, 1, 5000, '2022-01-01', '2022-12-31', 'Monthly', 'USD');

READ:
SELECT * FROM Salaries;

UPDATE:
UPDATE Salaries
SET SalaryAmount = 5500
WHERE SalaryID = 1;

DELETE:
DELETE FROM Salaries
WHERE SalaryID = 1;

# CRUD operations for LeaveRequests table:

CREATE:
INSERT INTO LeaveRequests (LeaveRequestID, EmployeeID, StartDate, EndDate, RequestStatus)
VALUES (1, 1, '2022-06-01', '2022-06-07', 'Pending');

READ:
SELECT * FROM LeaveRequests;

UPDATE:
UPDATE LeaveRequests
SET RequestStatus = 'Approved'
WHERE LeaveRequestID = 1;

DELETE:
DELETE FROM LeaveRequests
WHERE LeaveRequestID = 1;