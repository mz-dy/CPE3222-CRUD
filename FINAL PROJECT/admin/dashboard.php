<?php
require_once __DIR__ . '/../config.php';
require_admin();

$pdo = pdo();

$q = trim($_GET['q'] ?? '');
$date_from = trim($_GET['date_from'] ?? '');
$date_to = trim($_GET['date_to'] ?? '');
$action = trim($_GET['action'] ?? '');

$where = [];
$params = [];

if ($q !== '') {
    $where[] = '(u.usc_id LIKE ? OR u.first_name LIKE ? OR u.middle_name LIKE ? OR u.last_name LIKE ? OR CONCAT(u.first_name, " ", u.last_name) LIKE ? OR u.barangay LIKE ? OR u.city LIKE ? OR u.province LIKE ?)';
    $like = '%' . $q . '%';
    $params = array_merge($params, array_fill(0, 8, $like));
}
if ($action === 'in' || $action === 'out') {
    $where[] = 'v.action = ?';
    $params[] = $action;
}
if ($date_from !== '') {
    $where[] = 'DATE(v.timestamp) >= ?';
    $params[] = $date_from;
}
if ($date_to !== '') {
    $where[] = 'DATE(v.timestamp) <= ?';
    $params[] = $date_to;
}

$sql = 'SELECT v.id AS visit_id, v.action, v.timestamp, u.id AS user_id, u.usc_id, u.first_name, u.middle_name, u.last_name, u.barangay, u.city, u.province, u.contact_number, u.email
        FROM visits v
        INNER JOIN users u ON u.id = v.user_id';

if ($where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY v.timestamp DESC, v.id DESC LIMIT 500';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$visits = $stmt->fetchAll();

$userStmt = $pdo->query('SELECT id, usc_id, first_name, middle_name, last_name, barangay, city, province, contact_number, email, created_at, updated_at FROM users ORDER BY last_name ASC, first_name ASC');
$users = $userStmt->fetchAll();

$totalUsers = (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$totalVisits = (int)$pdo->query('SELECT COUNT(*) FROM visits')->fetchColumn();
$activeInStmt = $pdo->query("SELECT COUNT(*) FROM (SELECT v1.user_id, v1.action FROM visits v1 WHERE NOT EXISTS (SELECT 1 FROM visits v2 WHERE v2.user_id = v1.user_id AND (v2.timestamp > v1.timestamp OR (v2.timestamp = v1.timestamp AND v2.id > v1.id))) ) latest WHERE latest.action = 'in'");
$activeIn = (int)$activeInStmt->fetchColumn();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Bricolage Grotesque' rel='stylesheet'>
  <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <nav class="header">
    <div class="header-left">
      <img src="../images/dcpe2.png" style="width: 70px; height: 70px;">
      <div class="brand">
        <h1>Contact Tracing Application</h1>
        <p>USC Department of Computer Engineering</p>
      </div>
    </div>
    <div class="header-right">
      <div class="actions">
        <a class="btn btn-primary" href="../index.php">Manage User Session</a>
        <a class="btn btn-primary" href="login.php">Administrator Login</a>
      </div>
    <div>
  </nav>

  <div class="main">
    <div class="container">
      <?php if ($msg = flash('success')): ?>
        <div class="alert alert-success"><?= e($msg) ?></div>
      <?php endif; ?>
      <?php if ($msg = flash('error')): ?>
        <div class="alert alert-error"><?= e($msg) ?></div>
      <?php endif; ?>
      <div class="topbar">
        <div class="caption">
          <h1>Administrator Dashboard</h1>
          <p class="text">Search, review, and delete users and visit logs.</p>
        </div>
        <div class="actions">
          <a class="btn btn-danger" href="logout.php">Logout <img src="../images/logout.png" class="h-icon-2"></a>
        </div>
      </div>

      <div class="card card-pad" style="margin-top:18px;">
        <div class="top-card">
          <div>
            <img src="../images/search.png" class="h-icon">
            <h2>Search Visit Logs</h2> 
          </div>
        </div>
        <form method="get" class="grid grid-2" style="margin-top:14px;">
          <!--<div class="grid grid-2">-->
            <div>
              <label>Enter term to search</label>
              <input type="text" name="q" value="<?= e($q) ?>" placeholder="Search term">
            </div>
            <div>
              <label>Search By</label>
              <select name="action">
                <option value="name">ID Number</option>
                <option value="fname">First Name</option>
                <option value="lname">Last Name</option>
                <option value="barangay">Barangay</option>
                <option value="city">City</option>
                <option value="province">Province</option>
              </select>
            </div>
          <!--</div>-->
          
            <div>
              <label>From Date</label>
              <input type="date" name="date_from" value="<?= e($date_from) ?>">
            </div>
            <div>
              <label>To Date</label>
              <input type="date" name="date_to" value="<?= e($date_to) ?>">
            </div>
          
          
            <div class="actions" style="align-self:end;">
              <button class="btn btn-primary" type="submit">Search<img src="../images/search.png" class="h-icon-2"></button>
              <a class="btn btn-primary" href="dashboard.php">Reset</a>
            </div>
            
            <span class="total">Total Users: 10</span>                                    <!-- DUMMY VALUE -->
          
        </form>
        <div class="table-wrap" style="margin-top:16px;">
          <table>
            <thead>
              <tr>
                <th>Time / Date</th>
                <th>Action</th>
                <th>ID Number</th>
                <th>Name</th>
                <th>User Type</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Manage</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!$visits): ?>
                <tr><td colspan="8">No records found.</td></tr>
              <?php endif; ?>
              <?php foreach ($visits as $row): ?>
                <tr>
                  <td><?= e(date('M d, Y h:i A', strtotime($row['timestamp']))) ?></td>
                  <td><span class="badge <?= $row['action'] === 'in' ? 'badge-in' : 'badge-out' ?>"><?= strtoupper(e($row['action'])) ?></span></td>
                  <td><?= e($row['usc_id']) ?></td>
                  <td><?= e(trim($row['last_name'] . ', ' . $row['first_name'] . ' ' . $row['middle_name'])) ?></td>
                  <td>Student</td>
                  <td><?= e($row['barangay']) ?>, <?= e($row['city']) ?>, <?= e($row['province']) ?></td>
                  <td><?= e($row['contact_number']) ?></td>
                  <td><?= e($row['email']) ?></td>
                  <td class="actions">
                    <a class="btn btn-danger" href="user_delete.php?id=<?= (int)$row['user_id'] ?>" onclick="return confirm('Delete this user and all related visits?')">Delete<img src="../images/delete.png" class="h-icon-2"></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="card card-pad" style="margin-top:18px;">
        <div class="top-card">
          <div>
            <img src="../images/user-list.png" class="h-icon">
            <h2>User Directory</h2>
          </div>
        </div>
        <div class="table-wrap" style="margin-top:16px;">
          <table>
            <thead>
              <tr>
                <th>ID Number</th>
                <th>Name</th>
                <th>User Type</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Created</th>
                <th>Manage</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $u): ?>
                <tr>
                  <td><?= e($u['usc_id']) ?></td>
                  <td><?= e(trim($u['last_name'] . ', ' . $u['first_name'] . ' ' . $row['middle_name'])) ?></td>
                  <td>Student</td>
                  <td><?= e($u['barangay']) ?>, <?= e($u['city']) ?>, <?= e($u['province']) ?></td>
                  <td><?= e($u['contact_number']) ?></td>
                  <td><?= e($u['email']) ?></td>
                  <td><?= e(date('M d, Y', strtotime($u['created_at']))) ?></td>
                  <td class="actions">
                    <a class="btn btn-danger" href="user_delete.php?id=<?= (int)$u['id'] ?>" onclick="return confirm('Delete this user and all related visits?')">Delete<img src="../images/delete.png" class="h-icon-2"></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <div class="footer-logos">
        <img src="../images/usc.png" style="width: 35px; height: 35px;">
        <img src="../images/dcpe2.png" style="width: 35px; height: 35px;">
    </div>
    <p>© 2026 University of San Carlos Department of Computer Engineering</p>
</footer>
</body>
</html>
