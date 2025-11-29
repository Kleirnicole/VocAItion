<!-- User Management Section -->
<div class="management-section">
  <h2>User Management</h2>
  <div class="management-cards">
    <div class="m-card">
      <i class="fas fa-user-plus"></i>
      <h3>Add/Remove Users</h3>
      <p>Manage students and counselors.</p>
      <button class="btn">Manage</button>
    </div>
    <div class="m-card">
      <i class="fas fa-edit"></i>
      <h3>Edit User Details</h3>
      <p>Update user profiles and information.</p>
      <button class="btn">Edit</button>
    </div>
    <div class="m-card">
      <i class="fas fa-key"></i>
      <h3>Reset Passwords</h3>
      <p>Reset or update user passwords.</p>
      <button class="btn">Reset</button>
    </div>
    <div class="m-card">
      <i class="fas fa-clipboard-list"></i>
      <h3>User Activity Logs</h3>
      <p>View login and activity history.</p>
      <button class="btn">View Logs</button>
    </div>
  </div>
</div>
<style>
  .management-section {
  padding: 20px;
}

.management-section h2 {
  color: #1d3557;
  margin-bottom: 20px;
  font-size: 24px;
}

.management-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
}

.m-card {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.m-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.m-card i {
  font-size: 30px;
  color: #1d3557;
  margin-bottom: 10px;
}

.m-card h3 {
  color: #1d3557;
  margin: 10px 0;
}

.m-card p {
  font-size: 14px;
  color: #666;
  margin-bottom: 10px;
}

.m-card .btn {
  padding: 8px 14px;
  border: none;
  border-radius: 6px;
  background: #1d3557;
  color: #fff;
  cursor: pointer;
  transition: background 0.3s;
}

.m-card .btn:hover {
  background: #457b9d;
}

</style>