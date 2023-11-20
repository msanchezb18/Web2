<?php
include_once('codigos/conexion.inc');

$departmentCode = isset($_GET['department_code']) ? $_GET['department_code'] : '';
$employeeId = isset($_GET['employee_id']) ? $_GET['employee_id'] : '';

$sql = "
    SELECT
        d.dept_name AS department,
        e.emp_no,
        e.first_name AS name,
        e.last_name,
        t.title,
        s.salary AS c_salary,
        (s.salary * 1.1) AS n_salary,
        ((s.salary * 1.1) - s.salary) AS difference
    FROM
        employees e
    JOIN
        dept_emp de ON e.emp_no = de.emp_no
    JOIN
        departments d ON de.dept_no = d.dept_no
    JOIN
        titles t ON e.emp_no = t.emp_no
    JOIN
        salaries s ON e.emp_no = s.emp_no
    WHERE
        de.to_date = '9999-01-01'
        AND t.to_date = '9999-01-01'
        AND s.to_date = '9999-01-01'
        AND (d.dept_no = ? OR ? = '0')
        AND (e.emp_no = ? OR ? = '0')
    ORDER BY
        name ASC;
";


$stmt = mysqli_prepare($conex, $sql);

mysqli_stmt_bind_param($stmt, "ssss", $departmentCode, $departmentCode, $employeeId, $employeeId);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><enterprise></enterprise>');
$enterprise = $xml->addChild('name', 'Employees');
$enterprise->addChild('department', $departmentCode);
$enterprise->addChild('title', 'Projection of salary increase');

$summary = $xml->addChild('summary');

while ($row = mysqli_fetch_assoc($result)) {
    $department = $summary->addChild('department');
    $department->addChild('name', $row['department']);
    
    $employee = $department->addChild('employees')->addChild('employee');
    $employee->addChild('emp_no', $row['emp_no']);
    $employee->addChild('name', $row['name'] . ' ' . $row['last_name']);
    $employee->addChild('title', $row['title']);
    $employee->addChild('c_salary', $row['c_salary']);
    $employee->addChild('n_salary', $row['n_salary']);
    $employee->addChild('difference', $row['difference']);
}

header('Content-Type: application/xml');

if ($_GET['action'] == 'view') {
    echo $xml->asXML();
} elseif ($_GET['action'] == 'download') {
    header('Content-Disposition: attachment; filename="reporte.xml"');
    echo $xml->asXML();
}
mysqli_stmt_close($stmt);
mysqli_close($conex);
?>