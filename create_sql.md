CREATE DATABASE employee_management;
USE employee_management;

-- drop database employee_management;

CREATE TABLE Departments (
    DepartmentID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    DepartmentName VARCHAR(50) NOT NULL,
    DepartmentLocation VARCHAR(100),
    Budget DECIMAL(10,2)
);

CREATE TABLE Employees (
    EmployeeID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Email VARCHAR(50) UNIQUE NOT NULL,
    Phone VARCHAR(20),
    Address VARCHAR(100),
    DepartmentID INT NOT NULL,
    ManagerID INT,
    HireDate DATE,
    Gender CHAR(1),
    DateOfBirth DATE,
    FOREIGN KEY (DepartmentID) REFERENCES Departments(DepartmentID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (ManagerID) REFERENCES Employees(EmployeeID)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE Salaries (
    SalaryID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    EmployeeID INT NOT NULL,
    SalaryAmount DECIMAL(10,2) NOT NULL,
    StartDate DATE NOT NULL,
    EndDate DATE NOT NULL,
    PayType VARCHAR(20),
    Currency VARCHAR(10),
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE LeaveRequests (
    LeaveRequestID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    EmployeeID INT NOT NULL,
    StartDate DATE NOT NULL,
    EndDate DATE NOT NULL,
    RequestStatus VARCHAR(20),
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Employees table trigger to enforce unique email addresses
DELIMITER //
CREATE PROCEDURE check_employee_email(IN emp_id INT, IN emp_email VARCHAR(50), OUT result INT)
BEGIN
    SELECT COUNT(*) INTO result FROM Employees WHERE Email = emp_email AND EmployeeID != emp_id;
END//

CREATE TRIGGER trg_employees_insert_email
BEFORE INSERT ON Employees
FOR EACH ROW
BEGIN
    DECLARE email_count INT;
    CALL check_employee_email(NEW.EmployeeID, NEW.Email, email_count);
    IF email_count > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Email address must be unique';
    END IF;
END//

CREATE TRIGGER trg_employees_update_email
BEFORE UPDATE ON Employees
FOR EACH ROW
BEGIN
    DECLARE email_count INT;
    CALL check_employee_email(NEW.EmployeeID, NEW.Email, email_count);
    IF email_count > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Email address must be unique';
    END IF;
END//

DELIMITER ;

-- Salaries table trigger to ensure salary dates do not overlap for each employee

DELIMITER //
CREATE PROCEDURE check_salary_overlap(IN emp_id INT, IN start_date DATE, IN end_date DATE, IN salary_id INT, OUT result INT)
BEGIN
    SELECT COUNT(*) INTO result
    FROM Salaries
    WHERE EmployeeID = emp_id
    AND ((start_date BETWEEN StartDate AND EndDate)
         OR (end_date BETWEEN StartDate AND EndDate))
    AND SalaryID != salary_id;
END//

CREATE TRIGGER trg_salaries_insert_overlap
BEFORE INSERT ON Salaries
FOR EACH ROW
BEGIN
    DECLARE overlap_count INT;
    CALL check_salary_overlap(NEW.EmployeeID, NEW.StartDate, NEW.EndDate, NEW.SalaryID, overlap_count);
    IF overlap_count > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Salary dates cannot overlap';
    END IF;
END//

CREATE TRIGGER trg_salaries_update_overlap
BEFORE UPDATE ON Salaries
FOR EACH ROW
BEGIN
    DECLARE overlap_count INT;
    CALL check_salary_overlap(NEW.EmployeeID, NEW.StartDate, NEW.EndDate, NEW.SalaryID, overlap_count);
    IF overlap_count > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Salary dates cannot overlap';
    END IF;
END//

DELIMITER ;


-- LeaveRequests table trigger to check valid request status for leave requests

DELIMITER //
CREATE PROCEDURE check_leave_request_status(IN request_status VARCHAR(20), OUT result INT)
BEGIN
    IF request_status NOT IN ('Pending', 'Approved', 'Rejected') THEN
        SET result = 1;
    ELSE
        SET result = 0;
    END IF;
END//

CREATE TRIGGER trg_leaverequests_insert_requeststatus
BEFORE INSERT ON LeaveRequests
FOR EACH ROW
BEGIN
    DECLARE status_check INT;
    CALL check_leave_request_status(NEW.RequestStatus, status_check);
    IF status_check = 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid RequestStatus';
    END IF;
END//

CREATE TRIGGER trg_leaverequests_update_requeststatus
BEFORE UPDATE ON LeaveRequests
FOR EACH ROW
BEGIN
    DECLARE status_check INT;
    CALL check_leave_request_status(NEW.RequestStatus, status_check);
    IF status_check = 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid RequestStatus';
    END IF;
END//

DELIMITER ;

