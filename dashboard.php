<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>NS-EMP Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles (existing file) -->
  <link rel="stylesheet" href="./style.css" />
</head>
<body class="min-vh-100 d-flex flex-column">

      <!-- Topbar -->
      <nav class="navbar navbar-light border-bottom fixed-top text-white bg" style="background-color: #030608 !important;">
        <div class="container-fluid">
          <button class="btn btn-outline-success" id="sidebarToggle" aria-label="Toggle sidebar">
            ☰
          </button>
          <span class="navbar-brand ms-2 text-white">NS-EMP Dashboard</span>
          <div class="d-flex align-items-center">
            <span class="me-3 small  text-white">Admin</span>
            <img src="admin.jpeg" class="rounded-circle" alt="avatar" style="width: 50px;">
          </div>
        </div>
      </nav>

      <!-- Layout -->
      <div class="d-flex flex-grow-1">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-light border-end position-fixed bg" style="top: 56px; left: 0; height: calc(100vh - 56px); width: 200px; overflow-y: auto;">
          <div class="sidebar-brand p-3 border-bottom text-center">
            <img src="./northshore-logo-horizontal.png" alt="NS Apparel Logo" class="img-fluid mb-2 width-75">
          </div>
          <!-- Sidebar Navigation links -->
          <nav class="nav flex-column p-2">
            <a class="nav-link active" href="#" id="navOverview"><i class="bi bi-house-door me-2"></i>Overview</a>
            <a class="nav-link" href="#" id="navViewEmployees"><i class="bi bi-people me-2"></i>View Employees</a>
            <a class="nav-link" href="#" id="navViewTrainees"><i class="bi bi-person-lines-fill me-2"></i>View Trainees</a>
            <a class="nav-link" href="#" id="navPayroll"><i class="bi bi-cash-stack me-2"></i>Payroll</a>
            <a class="nav-link" href="#" id="navTraineePayroll"><i class="bi bi-cash me-2"></i>Trainee Payroll</a>
            <a class="nav-link" href="#" id="navEmployees"><i class="bi bi-people me-2"></i>Add Employees</a>
            <a class="nav-link" href="#" id="navAddTrainee"><i class="bi bi-person-plus me-2"></i>Add Trainee</a>
            <a class="nav-link" href="#" id="navSettings"><i class="bi bi-gear me-2"></i>Settings</a>
          </nav>
          <div class="position-absolute bottom-1 start-0 end-0 p-4">
            <a class="nav-link text-danger btn btn-danger w-100" href="logout.php">Sign out</a>
          </div>
        </aside>

        <!-- Main content -->
        <main id="mainContent" class="flex-grow-1 p-4" style="margin-left: 200px; margin-top: 56px">
          <div class="container-fluid">

            <!-- Overview Section -->
            <div id="overviewSection">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Dashboard Overview</h4>
                <small class="text-muted">Key metrics and insights</small>
              </div>
              <div class="row g-3">
                <div class="col-md-3">
                  <div class="card text-center">
                    <div class="card-body">
                      <h5 class="card-title">Total Employees</h5>
                      <p class="card-text display-4"><?php include 'get_counts.php'; echo $total_employees; ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card text-center">
                    <div class="card-body">
                      <h5 class="card-title">Total Trainees</h5>
                      <p class="card-text display-4"><?php include 'get_counts.php'; echo $total_trainees; ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card text-center">
                    <div class="card-body">
                      <h5 class="card-title">Active Shifts</h5>
                      <p class="card-text display-4"><?php include 'get_counts.php'; echo $active_shifts; ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card text-center">
                    <div class="card-body">
                      <h5 class="card-title">Departments</h5>
                      <p class="card-text display-4"><?php include 'get_counts.php'; echo $departments; ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="card text-center">
                    <div class="card-body">
                      <h5 class="card-title">New Hires</h5>
                      <p class="card-text display-4"><?php include 'get_counts.php'; echo $new_hires; ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          <!-- View Employees Section -->
            <div id="Viewemployee" class="d-none">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Employee Details</h4>
                <small class="text-muted">Create, Delete or update employee records</small>
              </div>

              <!-- Toolbar -->
              <div class="d-flex justify-content-between align-items-center mb-3">
                <input type="text" id="searchInputEmp" class="form-control w-50" placeholder="Search employees">
                <div>
                  <button class="btn btn-sm btn-success" onclick="exportEmployeeToPDF()">Export to PDF</button>
                  <button class="btn btn-sm btn-primary" onclick="exportEmployeeToExcel()">Export to Excel</button>
                  <button class="btn btn-sm btn-info" onclick="printEmployeeTable()">Print All</button>
                  <button class="btn btn-sm btn-warning" onclick="printEmployeeById()">Print by ID</button>
                </div>
              </div>


              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="employeeTable" class="table table-striped table-sm">
                      <thead>
                        <tr>
                          <th>Surname</th>
                          <th>Firstname</th>
                          <th>ID Number</th>
                          <th>Phone</th>
                          <th>Ghana Card</th>
                          <th>DOB</th>
                          <th>Gender</th>
                          <th>Shift</th>
                          <th>Disability</th>
                          <th>Commencement</th>
                          <th>Email</th>
                          <th>Department</th>
                          <th>Role</th>
                          <th>Type</th>
                          <th>Location</th>
                          <th>Marital Status</th>
                          <th>SSNIT</th>
                          <th>Actions</th>
                        </tr> 
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>

    <!--View Trainee From-->
            <div id="viewTraineeSection" class="d-none">
              <!-- Header with logo -->
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Northshore Apparel GH Ltd <br><small>(Trainee Records)</small></h4>
                <img src="nslogo.png" alt="Company Logo" style="height:60px;">
              </div>

                <!-- Toolbar -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <input type="text" id="searchInput" class="form-control w-50" placeholder="Search trainees">
                  <div>
                    <button class="btn btn-sm btn-success" onclick="exportToPDF()">Export to PDF</button>
                    <button class="btn btn-sm btn-primary" onclick="exportToExcel()">Export to Excel</button>
                    <button class="btn btn-sm btn-info" onclick="printTable()">Print All</button>
                    <button class="btn btn-sm btn-warning" onclick="printById()">Print by ID</button>
                  </div>
                </div>

      <!-- Table -->
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
            <table id="traineeTable" class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>ID Number</th>
                  <th>Ghana Card</th>
                  <th>Surname</th>
                  <th>Firstname</th>
                  <th>Gender</th>
                  <th>DOB</th>
                  <th>Phone</th>
                  <th>Marital Status</th>
                  <th>Track</th>            
                  <th>Shift</th>
                  <th>Next of Kin</th>
                  <th>Next of kin Contact</th>
                  <th>Location</th>
                  <th>Religion</th>
                  <th>Disability</th>
                  <th>District</th>
                  <th>Region</th>
                  <th>Start Date</th>
                  <th>Duration</th>
                  <!-- Actions excluded from export/print -->
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <!-- Rows go here -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  <!--Add Employee From-->
        <div id="employeeFormSection" class="d-none">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"> Add Employee Form</h4>
            <small class="text-muted">Employee records</small>
          </div>

          <div class="card shadow-sm">
            <div class="card-body">
              <form id="employeeForm" class="row g-3 needs-validation" novalidate>

              <div class="col-md-4">
                <label for="empSurname" class="form-label">Surname</label>
                <input type="text" class="form-control" id="empSurname" name="empSurname" required>
                <div class="invalid-feedback">Please enter a name.</div>
              </div>
              
              <div class="col-md-4">
                <label for="empFirstname" class="form-label">Firstname</label>
                <input type="text" class="form-control" id="empFirstname" name="empFirstname" required>
                <div class="invalid-feedback">Please enter a name.</div>
              </div>

               <div class="col-md-4">
                <label for="empIDno" class="form-label">ID Number</label>
                <input type="text" class="form-control" id="empIDno" name="empIDno" required>
                <div class="invalid-feedback">Please enter a Emp ID No.</div>
              </div>

              <div class="col-md-4">
                <label for="empPhone" class="form-label">Emp Phone Number</label>
                <input type="tel" class="form-control" id="empPhone" name="empPhone" required>
                <div class="invalid-feedback">Please enter a Emp ID No.</div>
              </div>

              <div class="col-md-4">
                <label for="empGhanaCard" class="form-label">Ghana Card Number</label>
                <input type="text" class="form-control" id="empGhanaCard" name="empGhanaCard" required>
                <div class="invalid-feedback">Please provide a valid Ghana Card.</div>
              </div>

              <div class="col-md-4">
                <label for="empDob" class="form-label">Dob</label>
                <input type="date" class="form-control" id="empDob" name="empDob" required>
                <div class="invalid-feedback">Please provide a valid  Date of Birth.</div>
              </div>

               <div class="col-md-4">
                <label for="empGender" class="form-label">Gender</label>
                <select id="empGender" class="form-select" name="empGender" required>
                  <option value="">Choose Gender</option>
                  <option>Male</option>
                  <option>Female</option>
                  <option>Other</option>
                </select>
                <div class="invalid-feedback">Please select a gender.</div>
              </div>

              <div class="col-md-4">
                <label for="empShift" class="form-label">Shift</label>
                <select id="empShift" class="form-select" name="empShift" required>
                  <option value="">Choose Shift</option>
                  <option>Regular</option>
                  <option>Track 1</option>
                  <option>Track 2</option>
                </select>
                <div class="invalid-feedback">Please select a gender.</div>
              </div>

              <div class="col-md-4">
                <label for="empDisability" class="form-label">Disability</label>
                <select id="empDisability" class="form-select" name="empDisability" required>
                  <option value="">Choose Disability</option>
                  <option>None</option>
                  <option>Disabled</option>
                  <option>Deaf</option>
                  <option>Leaping</option>
                </select>
                <div class="invalid-feedback">Please select a gender.</div>
              </div>

              <div class="col-md-4">
                <label for="empCommencement" class="form-label">Comemcement Date</label>
                <input type="date" class="form-control" id="empCommencement" name="empCommencement" required>
                <div class="invalid-feedback">Please provide a valid Comemcement Date.</div>
              </div>

               <div class="col-md-4">
                <label for="empEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="empEmail" name="empEmail" required>
                <div class="invalid-feedback">Please provide a valid email.</div>
              </div>

             
               <div class="col-md-4">
                <label for="empDep" class="form-label">Department</label>
                <select id="empDep" class="form-select" name="empDep" required>
                  <option value="">Choose Department</option>
                  <option>Printing</option>
                  <option>IT</option>
                  <option>Compliance</option>
                  <option>HR</option>
                  <option>Finance</option>
                  <option>Quality</option>
                </select>
                <div class="invalid-feedback">Please select a Department.</div>
              </div>

              <div class="col-md-4">
                <label for="empRole" class="form-label">Role</label>
                <select id="empRole" class="form-select" name="empRole" required>
                  <option value="">Choose...</option>
                  <option>Graduate-Operator</option>
                  <option>Graduate-IT</option>
                  <option>Graduate-Supervisor</option>
                  <option>Graduate-HR</option>
                </select>
                <div class="invalid-feedback">Please select a role.</div>
              </div>

              <div class="col-md-4">
                <label for="empType" class="form-label">Employment Type</label>
                <select id="empType" class="form-select" name="empType" required>
                  <option value="">Choose...</option>
                  <option>Full Time</option>
                  <option>Part Time</option>
                  <option>Casual Worker</option>
                </select>
                <div class="invalid-feedback">Please select a role.</div>
              </div>

               <div class="col-md-4">
                <label for="empLocation" class="form-label">Location</label>
                <input type="text" class="form-control" id="empLocation" name="empLocation" required>
                <div class="invalid-feedback">Please provide a valid Location.</div>
              </div>


              <div class="col-md-4">
                <label for="empMarital" class="form-label">Marital Status</label>
                <input type="text" class="form-control" id="empMarital" name="empMarital" required>
                <div class="invalid-feedback">Please provide a valid Marital Status.</div>
              </div>

              <div class="col-md-4">
                <label for="empSSNIT" class="form-label">SSNIT</label>
                <input type="text" class="form-control" id="empSSNIT" name="empSSNIT" required>
                <div class="invalid-feedback">Please provide a valid SSNIT.</div>
              </div>

              <div class="col-12">
                <button type="submit" id="submit" class=" btn btn-primary">Add Employee</button>
              </div>
            </form>
            <!--Upload Employee Excel File-->
            <form action="upload_employees.php" method="post" enctype="multipart/form-data" class="mt-4">
            <div class="row">  
                <div class="col-md-6">
                  <label for="file" class="form-label">Upload Employee Excel File:</label>
                  <input type="file" name="file" id="file" class="form-control" accept=".xls,.xlsx,.csv">
                  <div class="form-text">Accepted formats: .xls, .xlsx, .csv</div>
                </div>

                <div class="col-md-6">
                  <button type="submit" class="form-control btn btn-primary">Upload</button>
                </div>
              </div>
            </form>

          </div>
        </div>
        </div>


            <!-- Add Trainee -->
            <div id="traineeFormSection" class="d-none">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Add Trainee</h4>
                <small class="text-muted">Add new trainee information</small>
              </div>

              <div class="card shadow-sm">
                <div class="card-body">
                  <form id="traineeForm" class="row g-3 needs-validation" novalidate>

                    <!-- ID Number -->
                    <div class="col-md-4">
                      <label for="traineeIDno" class="form-label">ID Number</label>
                      <input type="text" class="form-control" id="traineeIDno" name="traineeIDno" required>
                      <div class="invalid-feedback">Please enter an ID number.</div>
                    </div>

                    <!-- Ghana Card -->
                    <div class="col-md-4">
                      <label for="traineeGhanaCard" class="form-label">Ghana Card Number</label>
                      <input type="text" class="form-control" id="traineeGhanaCard" name="traineeGhanaCard" required>
                      <div class="invalid-feedback">Please provide a valid Ghana Card.</div>
                    </div>

                    <!-- Surname -->
                    <div class="col-md-4">
                      <label for="traineeSurname" class="form-label">Surname</label>
                      <input type="text" class="form-control" id="traineeSurname" name="traineeSurname" required>
                      <div class="invalid-feedback">Please enter a surname.</div>
                    </div>

                    <!-- Firstname -->
                    <div class="col-md-4">
                      <label for="traineeFirstname" class="form-label">Firstname</label>
                      <input type="text" class="form-control" id="traineeFirstname" name="traineeFirstname" required>
                      <div class="invalid-feedback">Please enter a firstname.</div>
                    </div>

                    <!-- Gender -->
                    <div class="col-md-4">
                      <label for="traineeGender" class="form-label">Gender</label>
                      <select id="traineeGender" class="form-select" name="traineeGender" required>
                        <option value="">Choose Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                      </select>
                      <div class="invalid-feedback">Please select a gender.</div>
                    </div>

                    <!-- Date of Birth -->
                    <div class="col-md-4">
                      <label for="traineeDob" class="form-label">Date of Birth</label>
                      <input type="date" class="form-control" id="traineeDob" name="traineeDob" required>
                      <div class="invalid-feedback">Please provide a valid date of birth.</div>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-4">
                      <label for="traineePhone" class="form-label">Phone Number</label>
                      <input type="tel" class="form-control" id="traineePhone" name="traineePhone" required>
                      <div class="invalid-feedback">Please enter a phone number.</div>
                    </div>

                    <!-- Marital Status -->
                    <div class="col-md-4">
                      <label for="traineeMarital" class="form-label">Marital Status</label>
                      <input type="text" class="form-control" id="traineeMarital" name="traineeMarital" required>
                      <div class="invalid-feedback">Please provide your Marital Status.</div>
                    </div>

                    <!-- Track -->
                    <div class="col-md-4">
                      <label for="traineeTrack" class="form-label">Track</label>
                      <select id="traineeTrack" class="form-select" name="traineeTrack" required>
                        <option value="">Choose Track</option>
                        <option value="Track 1">Track 1</option>
                        <option value="Track 2">Track 2</option>
                      </select>
                      <div class="invalid-feedback">Please select a track.</div>
                    </div>

                    <!-- Shift -->
                    <div class="col-md-4">
                      <label for="traineeShift" class="form-label">Shift</label>
                      <select id="traineeShift" class="form-select" name="traineeShift" required>
                        <option value="">Choose Shift</option>
                        <option value="Morning">Morning</option>
                        <option value="Afternoon">Afternoon</option>
                      </select>
                      <div class="invalid-feedback">Please select a Shift.</div>
                    </div>

                    <!-- Next of Kin -->
                    <div class="col-md-4">
                      <label for="traineeNextofkin" class="form-label">Next of Kin</label>
                      <input type="text" class="form-control" id="traineeNextofkin" name="traineeNextofkin" required>
                      <div class="invalid-feedback">Please provide your Next of Kin.</div>
                    </div>

                    <!-- Next of Kin Contact (FIXED ID) -->
                    <div class="col-md-4">
                      <label for="traineeNextofkinContact" class="form-label">Next of Kin Contact</label>
                      <input type="tel" class="form-control" id="traineeNextofkinContact" name="traineeNextofkinContact" required>
                      <div class="invalid-feedback">Please provide your Next of Kin Contact.</div>
                    </div>

                    <!-- Location -->
                    <div class="col-md-4">
                      <label for="traineeLocation" class="form-label">Location</label>
                      <input type="text" class="form-control" id="traineeLocation" name="traineeLocation" required>
                      <div class="invalid-feedback">Please provide your Location.</div>
                    </div>

                    <!-- Religion -->
                    <div class="col-md-4">
                      <label for="traineeReligion" class="form-label">Religion</label>
                      <select id="traineeReligion" class="form-select" name="traineeReligion" required>
                        <option value="">Choose Religion</option>
                        <option value="Islam">Islam</option>
                        <option value="Christianity">Christianity</option>
                        <option value="Other">Other</option>
                      </select>
                      <div class="invalid-feedback">Please select a Religion.</div>
                    </div>

                    <!-- Disability -->
                    <div class="col-md-4">
                      <label for="traineeDisability" class="form-label">Disability</label>
                      <select id="traineeDisability" class="form-select" name="traineeDisability" required>
                        <option value="">Choose Disability</option>
                        <option value="N/A">N/A</option>
                        <option value="Deaf">Deaf</option>
                        <option value="Disabled">Disabled</option>
                      </select>
                      <div class="invalid-feedback">Please select a Disability.</div>
                    </div>

                    <!-- District -->
                    <div class="col-md-4">
                      <label for="traineeDistrict" class="form-label">District</label>
                      <input type="text" class="form-control" id="traineeDistrict" name="traineeDistrict" required>
                      <div class="invalid-feedback">Please provide your District.</div>
                    </div>

                    <!-- Region -->
                    <div class="col-md-4">
                      <label for="traineeRegion" class="form-label">Region</label>
                      <input type="text" class="form-control" id="traineeRegion" name="traineeRegion" required>
                      <div class="invalid-feedback">Please provide your Region.</div>
                    </div>

                    <!-- Start Date -->
                    <div class="col-md-4">
                      <label for="traineeStartDate" class="form-label">Training Start Date</label>
                      <input type="date" class="form-control" id="traineeStartDate" name="traineeStartDate" required>
                      <div class="invalid-feedback">Please provide a start date.</div>
                    </div>

                    <!-- Duration -->
                    <div class="col-md-4">
                      <label for="traineeDuration" class="form-label">Training Duration (Months)</label>
                      <input type="number" class="form-control" id="traineeDuration" name="traineeDuration" min="1" required>
                      <div class="invalid-feedback">Please enter training duration.</div>
                    </div>

                    <!-- Submit -->
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary">Add Trainee</button>
                    </div>

                  </form>
                </div>
              </div>
            </div>



            <!--Payroll-->
        <div id="payrollSection" class="d-none">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Payroll Management</h4>
            <small class="text-muted">Manage employee payroll records</small>
          </div>

              <!-- Toolbar -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <input type="text" id="searchInputPayroll" class="form-control w-50" placeholder="Search trainees">
        <div>
          <button class="btn btn-sm btn-success" onclick="exportPayrollToPDF()">Export to PDF</button>
          <button class="btn btn-sm btn-primary" onclick="exportPayrollToExcel()">Export to Excel</button>
          <button class="btn btn-sm btn-info" onclick="printPayrollTable()">Print All</button>
          <button class="btn btn-sm btn-warning" onclick="printPayrollById()">Print by ID</button>
        </div>
      </div>

          <div class="row">
            <div class="col-md-4">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title">Add Payroll</h5>
                  <form id="payrollForm" class="needs-validation" novalidate>
                    <div class="mb-3">
                      <label for="payrollEmployee" class="form-label">Employee ID</label>
                      <input type="text" class="form-control" id="payrollEmployee" name="payrollEmployee" required>
                    </div>
                    <div class="mb-3">
                      <label for="payrollMonth" class="form-label">Month</label>
                      <select id="payrollMonth" class="form-select" name="payrollMonth" required>
                        <option value="">Select Month</option>
                        <option>January</option>
                        <option>February</option>
                        <option>March</option>
                        <option>April</option>
                        <option>May</option>
                        <option>June</option>
                        <option>July</option>
                        <option>August</option>
                        <option>September</option>
                        <option>October</option>
                        <option>November</option>
                        <option>December</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="payrollYear" class="form-label">Year</label>
                      <input type="number" class="form-control" id="payrollYear" name="payrollYear" min="2020" max="2030" required>
                    </div>
                    <div class="mb-3">
                      <label for="basicSalary" class="form-label">Basic Salary</label>
                      <input type="number" class="form-control" id="basicSalary" name="basicSalary" step="0.01" required>
                    </div>
                    <div class="mb-3">
                      <label for="allowances" class="form-label">Allowances</label>
                      <input type="number" class="form-control" id="allowances" name="allowances" step="0.01" required>
                    </div>
                    <div class="mb-3">
                      <label for="deductions" class="form-label">Deductions</label>
                      <input type="number" class="form-control" id="deductions" name="deductions" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Payroll</button>
                  </form>
                </div>
              </div>
            </div>

            <div class="col-md-8">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title">Payroll Records</h5>
                  <div class="table-responsive">
                    <table id="payrollTable" class="table table-striped table-sm">
                      <thead>
                        <tr>
                          <th>Employee ID</th>
                          <th>Month</th>
                          <th>Year</th>
                          <th>Basic Salary</th>
                          <th>Allowances</th>
                          <th>Deductions</th>
                          <th>Net Salary</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        
            <!-- Trainee Payroll-->
        <div id="traineePayrollSection" class="d-none">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Trainee Payroll Management</h4>
            <small class="text-muted">Manage trainee payroll records</small>
          </div>

          <!-- Toolbar -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <input type="text" id="searchInputT_Payroll" class="form-control w-50" placeholder="Search trainees">
        <div>
          <button class="btn btn-sm btn-success" onclick="exportT_PayrollToPDF()">Export to PDF</button>
          <button class="btn btn-sm btn-primary" onclick="exportT_PayrollToExcel()">Export to Excel</button>
          <button class="btn btn-sm btn-info" onclick="printT_PayrollTable()">Print All</button>
          <button class="btn btn-sm btn-warning" onclick="printt_PayrollById()">Print by ID</button>
        </div>
      </div>

          <div class="row">
            <div class="col-md-4">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title">Add Trainee Payroll</h5>
                  <form id="traineePayrollForm" class="needs-validation" novalidate>
                    <div class="mb-3">
                      <label for="traineePayrollId" class="form-label">Trainee ID</label>
                      <input type="text" class="form-control" id="traineePayrollId" name="traineePayrollId" required>
                    </div>
                    <div class="mb-3">
                      <label for="traineePayrollMonth" class="form-label">Month</label>
                      <select id="traineePayrollMonth" class="form-select" name="traineePayrollMonth" required>
                        <option value="">Select Month</option>
                        <option>January</option>
                        <option>February</option>
                        <option>March</option>
                        <option>April</option>
                        <option>May</option>
                        <option>June</option>
                        <option>July</option>
                        <option>August</option>
                        <option>September</option>
                        <option>October</option>
                        <option>November</option>
                        <option>December</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="traineePayrollYear" class="form-label">Year</label>
                      <input type="number" class="form-control" id="traineePayrollYear" name="traineePayrollYear" min="2020" max="2030" required>
                    </div>
                    <div class="mb-3">
                      <label for="traineeBasicSalary" class="form-label">Basic Salary</label>
                      <input type="number" class="form-control" id="traineeBasicSalary" name="traineeBasicSalary" step="0.01" required>
                    </div>
                    <div class="mb-3">
                      <label for="traineeAllowances" class="form-label">Allowances</label>
                      <input type="number" class="form-control" id="traineeAllowances" name="traineeAllowances" step="0.01" required>
                    </div>
                    <div class="mb-3">
                      <label for="traineeDeductions" class="form-label">Deductions</label>
                      <input type="number" class="form-control" id="traineeDeductions" name="traineeDeductions" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Trainee Payroll</button>
                  </form>
                </div>
              </div>
            </div>

              
            <div class="col-md-8">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title">Trainee Payroll Records</h5>
                  <div class="table-responsive">
                    <table id="T_PayrollTable" class="table table-striped table-sm">
                      <thead>
                        <tr>
                          <th>Trainee ID</th>
                          <th>Month</th>
                          <th>Year</th>
                          <th>Basic Salary</th>
                          <th>Allowances</th>
                          <th>Deductions</th>
                          <th>Net Salary</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>



        <div id="settingsSection" class="d-none">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Settings</h4>
            <small class="text-muted">Configure application settings</small>
          </div>

          <div class="card shadow-sm">
            <div class="card-body">
              <form id="settingsForm" class="row g-3">
                <div class="col-md-6">
                  <label for="companyName" class="form-label">Company Name</label>
                  <input type="text" class="form-control" id="companyName" value="Northshore Apparel GH Ltd">
                </div>
                <div class="col-md-6">
                  <label for="adminEmail" class="form-label">Admin Email</label>
                  <input type="email" class="form-control" id="adminEmail" value="admin@nsapparel.com">
                </div>
                <div class="col-md-6">
                  <label for="timezone" class="form-label">Timezone</label>
                  <select id="timezone" class="form-select">
                    <option>GMT</option>
                    <option>GMT+1</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="language" class="form-label">Language</label>
                  <select id="language" class="form-select">
                    <option>English</option>
                    <option>French</option>
                  </select>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!--Footer--->
<div class="footer text-center border-top bg fixed-footer">
  <p class="mt-2 text-white">
    ©<?php echo date("Y"); ?> Northshore Apparel Ghana Limited
  </p>
</div>


  <!-- Bootstrap JS (bundle includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



  <script>
         // Set current year in footer
          document.addEventListener('DOMContentLoaded', function() {
            const yearSpan = document.getElementById('currentYear');
            if (yearSpan) {
              yearSpan.textContent = new Date().getFullYear();
            }
          });


          // Function to toggle sidebar
          function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            if (sidebar.style.display === 'none' || sidebar.style.display === '') {
              sidebar.style.display = 'block';
              mainContent.style.marginLeft = '200px';
            } else {
              sidebar.style.display = 'none';
              mainContent.style.marginLeft = '0';
            }
          }

          // Toggle sidebar on button click
          document.getElementById('sidebarToggle').addEventListener('click', toggleSidebar);

          // Hide sidebar on small screens by default
          function checkScreenSize() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            if (window.innerWidth < 768) {
              sidebar.style.display = 'none';
              mainContent.style.marginLeft = '0';
            } else {
              sidebar.style.display = 'block';
              mainContent.style.marginLeft = '200px';
            }
          }

          // Check on load and resize
          window.addEventListener('load', checkScreenSize);
          window.addEventListener('resize', checkScreenSize);

          // Form validation and submission
          (function () {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
              form.addEventListener('submit', function (e) {
                if (!form.checkValidity()) {
                  e.preventDefault();
                  e.stopPropagation();
                } else {
                  e.preventDefault();
                  saveFormData(form);
                }
                form.classList.add('was-validated');
              }, false);
            });
          })();

          

          // Nav section switching
          const sections = {
            'navOverview': 'overviewSection',
            'navEmployees': 'employeeFormSection',
            'navViewEmployees': 'Viewemployee',
            'navViewTrainees': 'viewTraineeSection',
            'navPayroll': 'payrollSection',
            'navTraineePayroll': 'traineePayrollSection',
            'navAddTrainee': 'traineeFormSection',
            'navSettings': 'settingsSection'
          };

          Object.keys(sections).forEach(navId => {
            document.getElementById(navId).addEventListener('click', function(e) {
              e.preventDefault();
              // Hide all sections
              Object.values(sections).forEach(sectionId => {
                document.getElementById(sectionId).classList.add('d-none');
              });
              // Show selected section
              document.getElementById(sections[navId]).classList.remove('d-none');
              // Update active nav
              document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
              this.classList.add('active');
            });
          });

          let isUpdate = false;
          let updateType = '';
          let updateId = '';
         

          //Switch to specific section
          function switchToSection(sectionId) {
            Object.values(sections).forEach(s => document.getElementById(s).classList.add('d-none'));
            document.getElementById(sectionId).classList.remove('d-none');
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            const navId = Object.keys(sections).find(key => sections[key] === sectionId);
            if (navId) document.getElementById(navId).classList.add('active');
          }


  </script>
    <script src="add_data.js"></script>
    <script src="view_data.js"></script>
    <script src="update.js"></script>
    <script src="delete.js"></script>
   <script src="search.js"></script>
   <script src="print.js"></script>
   <script src="export.js"></script>

  <!-- Include libraries for exportToPDF and exportToExcel -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

</body>