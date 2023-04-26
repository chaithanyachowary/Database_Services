-- Inserting data into Departments table
INSERT INTO Departments (DepartmentID, DepartmentName, DepartmentLocation, Budget) VALUES
(1, 'Marketing', 'New York', 50000),
(2, 'Human Resources', 'Chicago', 75000),
(3, 'IT', 'San Francisco', 100000),
(4, 'Sales', 'Los Angeles', 90000),
(5, 'Finance', 'Dallas', 80000);

-- Inserting data into Employees table
INSERT INTO Employees (EmployeeID, FirstName, LastName, Email, Phone, Address, DepartmentID, ManagerID, HireDate, Gender, DateOfBirth) VALUES
(1, 'John', 'Doe', 'johndoe@gmail.com', '1234567890', '123 Main St, New York, NY', 1, NULL, '2021-01-01', 'M', '1990-01-01'),
(2, 'Jane', 'Smith', 'janesmith@gmail.com', '9876543210', '456 Maple St, Chicago, IL', 2, 1, '2021-01-15', 'F', '1995-03-12'),
(3, 'Bob', 'Johnson', 'bobjohnson@gmail.com', '5555555555', '789 Oak St, San Francisco, CA', 3, 1, '2021-02-01', 'M', '1985-07-06'),
(4, 'Alice', 'Williams', 'alicewilliams@gmail.com', '1112223333', '321 Pine St, Los Angeles, CA', 4, 1, '2021-02-15', 'F', '1992-11-22'),
(5, 'Tom', 'Lee', 'tomlee@gmail.com', '555-123-4567', '987 Elm St, Dallas, TX', 5, 1, '2021-03-01', 'M', '1998-04-18');

-- Inserting data into Salaries table
INSERT INTO Salaries (SalaryID, EmployeeID, SalaryAmount, StartDate, EndDate, PayType, Currency) VALUES
(1, 1, 50000, '2021-01-01', '2022-01-01', 'Annual', 'USD'),
(2, 2, 60000, '2021-01-15', '2022-01-15', 'Annual', 'USD'),
(3, 3, 80000, '2021-02-01', '2022-02-01', 'Annual', 'USD'),
(4, 4, 70000, '2021-02-15', '2022-02-15', 'Annual', 'USD'),
(5, 5, 75000, '2021-03-01', '2022-03-01', 'Annual', 'USD');

-- Insert data into LeaveRequests table
INSERT INTO LeaveRequests (LeaveRequestID, EmployeeID, StartDate, EndDate, RequestStatus) VALUES
(1, 1, '2022-06-01', '2022-06-05', 'Pending'),
(2, 1, '2022-08-01', '2022-08-10', 'Approved'),
(3, 2, '2022-07-15', '2022-07-19', 'Rejected'),
(4, 3, '2022-10-01', '2022-10-03', 'Pending'),
(5, 2, '2022-05-01', '2022-05-03', 'Approved');


