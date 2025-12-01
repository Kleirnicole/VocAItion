<!-- System Monitoring Section -->
<div class="management-section">
  <h2>System Monitoring</h2>
  <div class="management-cards">
    <div class="m-card">
      <i class="fas fa-list"></i>
      <h3>System Logs</h3>
      <p>View login activity and system errors.</p>
      <button class="btn">View Logs</button>
    </div>
    <div class="m-card">
      <i class="fas fa-tachometer-alt"></i>
      <h3>Performance Check</h3>
      <p>Monitor server and system performance.</p>
      <button class="btn">Check</button>
    </div>
    <div class="m-card">
      <i class="fas fa-database"></i>
      <h3>Backup & Restore</h3>
      <p>Manage data backup and restore points.</p>
      <button class="btn">Manage</button>
    </div>
    <div class="m-card">
      <i class="fas fa-shield-alt"></i>
      <h3>Security Management</h3>
      <p>Set permissions and access levels.</p>
      <button class="btn">Configure</button>
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
