<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: /login.php');
  exit;
}

require_once __DIR__ . '/config/db.php';
$username = 'User';
try {
  $pdo = getPDO();
  $stmt = $pdo->prepare('SELECT username FROM users WHERE id = :id LIMIT 1');
  $stmt->execute([':id' => $_SESSION['user_id']]);
  $row = $stmt->fetch();
  if ($row) {
    $username = $row['username'];
  }
} catch (Exception $e) {
  // Use default
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Settings</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg:#f6f8f6;
      --sidebar:#ecf2ec;
      --card:#ffffff;
      --muted:#6b7280;
      --accent:#7c9d85;
      --accent-strong:#6a8b74;
      --border:#e8efe8;
      --badge:#e8efe5;
    }
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:Inter,system-ui,-apple-system,Segoe UI,sans-serif;background:var(--bg);color:#1f2a1f;display:flex;min-height:100vh;}

    /* Sidebar (unified) */
    .sidebar{width:250px;background:#ecf2ec;min-height:100vh;padding:20px 18px;display:flex;flex-direction:column;gap:12px;position:fixed;left:0;top:0;bottom:0}
    .brand{display:flex;align-items:center;gap:10px;margin-bottom:16px}
    .brand-icon{width:42px;height:42px;border-radius:12px;background:var(--accent);display:flex;align-items:center;justify-content:center;font-size:22px;color:#fff;font-weight:700}
    .brand-text{display:flex;flex-direction:column;gap:2px}
    .brand-title{font-weight:700;font-size:16px;color:#1f2a1f}
    .brand-sub{font-size:12px;color:#54625a}
    .nav{display:flex;flex-direction:column;gap:6px;margin-top:6px}
    .nav-item{display:flex;align-items:center;gap:12px;padding:12px 14px;border-radius:12px;cursor:pointer;color:#1f2a1f;font-weight:600;transition:all 0.18s ease}
    .nav-item:hover{background:#dde6df}
    .nav-item.active{background:var(--accent);color:#fff;box-shadow:0 6px 14px rgba(124,157,133,0.25)}
    .nav-icon{font-size:18px;width:22px;text-align:center}
    .sidebar-footer{margin-top:auto;background:#f0f5f0;border:1px solid #dce6de;border-radius:12px;padding:12px;display:flex;gap:10px;align-items:center;}
    .welcome{margin-top:auto;background:#f0f5f0;border:1px solid #dce6de;border-radius:12px;padding:12px;display:flex;align-items:center;gap:8px;font-size:13px;color:#1f2a1f}
    .badge{width:36px;height:36px;border-radius:10px;background:var(--badge);display:flex;align-items:center;justify-content:center;font-size:18px;}
    .footer-text{display:flex;flex-direction:column;gap:2px;}
    .footer-title{font-size:13px;font-weight:700;color:#1f2a1f;}
    .footer-sub{font-size:12px;color:var(--muted);}

    /* Main */
    .main{margin-left:250px;flex:1;padding:26px 34px;min-height:100vh}
    .page-head{margin-bottom:22px;}
    .page-title{font-size:30px;font-weight:700;letter-spacing:-0.02em;margin-bottom:6px;color:#1f2a1f;}
    .page-sub{color:var(--muted);font-size:15px;}

    .grid-2{display:grid;grid-template-columns:repeat(auto-fit,minmax(440px,1fr));gap:16px;margin-top:12px;}
    .card{background:var(--card);border-radius:18px;box-shadow:0 6px 18px rgba(0,0,0,0.06);border:1px solid var(--border);padding:14px 16px;}
    .card-title{font-weight:700;font-size:16px;margin-bottom:10px;color:#1f2a1f;}

    .row{display:flex;align-items:center;justify-content:space-between;padding:12px;border-radius:14px;border:1px solid var(--border);background:#f9fbf9;margin-bottom:8px;gap:12px;}
    .row .left{display:flex;align-items:center;gap:10px;}
    .icon-pill{width:34px;height:34px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;background:#eef3ef;color:#4c6b50;}
    .label-strong{font-weight:700;color:#1f2a1f;}
    .label-sub{font-size:13px;color:var(--muted);}

    .toggle{width:46px;height:24px;border-radius:24px;background:#dfe6e1;position:relative;cursor:pointer;flex-shrink:0;}
    .toggle::after{content:'';position:absolute;top:3px;left:3px;width:18px;height:18px;border-radius:50%;background:#fff;transition:all .2s ease;}
    .toggle.on{background:var(--accent);}
    .toggle.on::after{left:25px;}

    .theme-tabs{display:flex;gap:12px;margin-top:10px;}
    .theme-pill{flex:1;border:1px solid var(--border);border-radius:12px;padding:12px;display:flex;flex-direction:column;gap:6px;align-items:center;cursor:pointer;background:#fff;transition:all .2s;}
    .theme-pill.active{background:var(--accent);color:#fff;box-shadow:0 8px 18px rgba(0,0,0,0.1);border-color:transparent;}
    .theme-pill .big{font-size:20px;}
    .theme-pill .tlabel{font-weight:700;}

    .about-row{display:flex;align-items:center;gap:10px;padding:12px;border-radius:14px;border:1px solid var(--border);background:#f9fbf9;margin-top:8px;}

    .privacy{margin-top:14px;border-radius:18px;border:1px solid var(--border);background:#f3f8f3;padding:14px;}
    .privacy strong{display:block;margin-bottom:6px;color:#1f2a1f;}
    .privacy p{color:#4b5563;font-size:14px;line-height:1.6;}

    @media(max-width:1024px){
      .content{margin-left:0;padding:20px;}
      .sidebar{position:relative;width:100%;flex-direction:row;flex-wrap:wrap;gap:10px;align-items:center;border-right:none;border-bottom:1px solid var(--border);}
      .nav{flex-direction:row;flex-wrap:wrap;}
    }
  </style>
</head>
<body>
  <aside class="sidebar">
    <div class="brand">
      <div class="brand-icon">⭐</div>
      <div class="brand-text">
        <div class="brand-title">Mood Tracker</div>
        <div class="brand-sub">Track your wellbeing</div>
      </div>
    </div>
    <nav class="nav">
      <a class="nav-item" href="home.php"><span class="nav-icon">🏠</span>Home</a>
      <a class="nav-item" href="calendar.php"><span class="nav-icon">📅</span>Calendar</a>
      <a class="nav-item" href="daily-log.php"><span class="nav-icon">📖</span>Daily Log</a>
      <a class="nav-item" href="calming-tools.php"><span class="nav-icon">✨</span>Calming Tools</a>
      <a class="nav-item" href="flashcard.php"><span class="nav-icon">💬</span>Flashcards</a>
      <a class="nav-item" href="progress.php"><span class="nav-icon">📊</span>Progress</a>
      <a class="nav-item active" href="settings.php"><span class="nav-icon">⚙️</span>Settings</a>
    </nav>
    <div class="welcome" id="authSection" style="flex-direction:column;align-items:stretch;gap:12px">
      <div id="userInfo" style="display:flex">
        <div style="font-size:12px;color:#54625a">Logged in as</div>
        <div id="username" style="font-weight:700;color:#1f2a1f;margin-bottom:8px"><?php echo htmlspecialchars($username); ?></div>
        <a href="logout.php" style="display:inline-block;padding:6px 12px;background:#6a8b74;color:#fff;border-radius:8px;font-size:12px;text-align:center">Log out</a>
      </div>
      <div id="authPrompt" style="text-align:center;gap:8px;display:none;flex-direction:column">
        <div>Not logged in</div>
        <a href="login.php" style="padding:8px 12px;background:#7c9d85;color:#fff;border-radius:8px;font-size:13px;font-weight:600">Log in</a>
        <a href="register.php" style="padding:8px 12px;background:#e8efe8;color:#1f2a1f;border-radius:8px;font-size:13px;font-weight:600">Sign up</a>
      </div>
    </div>
  </aside>

  <main class="main">
    <div class="page-head">
      <div class="page-title">Settings</div>
      <div class="page-sub">Manage your preferences and permissions</div>
    </div>

    <div class="grid-2">
      <div class="card">
        <div class="card-title">Permissions</div>
        <div class="row">
          <div class="left">
            <div class="icon-pill">📷</div>
            <div>
              <div class="label-strong">Camera Access</div>
              <div class="label-sub">Enable facial emotion detection</div>
            </div>
          </div>
          <div class="toggle on"></div>
        </div>
        <div class="row">
          <div class="left">
            <div class="icon-pill">🎙️</div>
            <div>
              <div class="label-strong">Microphone Access</div>
              <div class="label-sub">Enable audio mood analysis</div>
            </div>
          </div>
          <div class="toggle on"></div>
        </div>
      </div>

      <div class="card">
        <div class="card-title">Appearance</div>
        <div class="label-strong" style="margin-bottom:6px;">Theme</div>
        <div class="theme-tabs">
          <div class="theme-pill active">
            <div class="big">☀️</div>
            <div class="tlabel">Light</div>
          </div>
          <div class="theme-pill">
            <div class="big">🌙</div>
            <div class="tlabel">Dark</div>
          </div>
          <div class="theme-pill">
            <div class="big">🎨</div>
            <div class="tlabel">Auto</div>
          </div>
        </div>
      </div>
    </div>

    <div class="grid-2">
      <div class="card">
        <div class="card-title">Notifications</div>
        <div class="row">
          <div class="left">
            <div class="icon-pill">🔔</div>
            <div>
              <div class="label-strong">Notifications</div>
              <div class="label-sub">Enable all notifications</div>
            </div>
          </div>
          <div class="toggle on"></div>
        </div>
        <div class="row">
          <div class="left">
            <div class="icon-pill" style="background:#fff5dc;color:#c78c0b;">⏰</div>
            <div>
              <div class="label-strong">Daily Reminder</div>
              <div class="label-sub">Remind me to log my mood</div>
            </div>
          </div>
          <div class="toggle on"></div>
        </div>
        <div class="row">
          <div class="left">
            <div class="icon-pill" style="background:#ffecec;color:#c25252;">✨</div>
            <div>
              <div class="label-strong">Smart Reminders</div>
              <div class="label-sub">Personalized suggestions based on patterns</div>
            </div>
          </div>
          <div class="toggle on"></div>
        </div>
      </div>

      <div class="card">
        <div class="card-title">Data Management</div>
        <div class="row">
          <div class="left">
            <div class="icon-pill" style="background:#e9f3ff;color:#2d6cb4;">🗂️</div>
            <div>
              <div class="label-strong">Local Data Backup</div>
              <div class="label-sub">Export your mood data</div>
            </div>
          </div>
          <div style="font-size:16px;color:#9ca3af;">›</div>
        </div>
        <div class="row">
          <div class="left">
            <div class="icon-pill" style="background:#e9f5ee;color:#2c8155;">⬇️</div>
            <div>
              <div class="label-strong">Download Data</div>
              <div class="label-sub">Get a copy of all your entries</div>
            </div>
          </div>
          <div style="font-size:16px;color:#9ca3af;">›</div>
        </div>
      </div>
    </div>

    <div class="grid-2">
      <div class="card">
        <div class="card-title">About</div>
        <div class="about-row">
          <div class="icon-pill" style="background:#f2f0ff;color:#6b5ca5;">ℹ️</div>
          <div>
            <div class="label-strong">About Mood Tracker</div>
            <div class="label-sub">Version 1.0.0</div>
          </div>
          <div style="margin-left:auto;font-size:16px;color:#9ca3af;">›</div>
        </div>
      </div>
    </div>

    <div class="privacy">
      <strong>Privacy First</strong>
      <p>All your mood data is stored locally on your device. Camera and microphone data is processed in real-time and never saved or shared. You have full control over your information.</p>
    </div>
  </main>

  <script>
    // Permission toggles
    const permissionToggles = {
      camera: document.querySelectorAll('.toggle')[0],
      microphone: document.querySelectorAll('.toggle')[1],
      notifications: document.querySelectorAll('.toggle')[2],
      dailyReminder: document.querySelectorAll('.toggle')[3],
      smartReminders: document.querySelectorAll('.toggle')[4]
    };

    // Theme pills
    const themePills = document.querySelectorAll('.theme-pill');

    // Load settings from localStorage
    function loadSettings() {
      // Permissions
      const cameraEnabled = localStorage.getItem('cameraEnabled') !== 'false';
      const micEnabled = localStorage.getItem('micEnabled') !== 'false';
      const notificationsEnabled = localStorage.getItem('notificationsEnabled') !== 'false';
      const dailyReminderEnabled = localStorage.getItem('dailyReminderEnabled') !== 'false';
      const smartRemindersEnabled = localStorage.getItem('smartRemindersEnabled') !== 'false';

      updateToggle(permissionToggles.camera, cameraEnabled);
      updateToggle(permissionToggles.microphone, micEnabled);
      updateToggle(permissionToggles.notifications, notificationsEnabled);
      updateToggle(permissionToggles.dailyReminder, dailyReminderEnabled);
      updateToggle(permissionToggles.smartReminders, smartRemindersEnabled);

      // Theme
      const theme = localStorage.getItem('theme') || 'light';
      themePills.forEach(pill => pill.classList.remove('active'));
      if (theme === 'light') themePills[0].classList.add('active');
      else if (theme === 'dark') themePills[1].classList.add('active');
      else if (theme === 'auto') themePills[2].classList.add('active');

      applyTheme(theme);
    }

    function updateToggle(toggle, isOn) {
      if (isOn) {
        toggle.classList.add('on');
      } else {
        toggle.classList.remove('on');
      }
    }

    function applyTheme(theme) {
      const root = document.documentElement;
      if (theme === 'dark') {
        root.style.setProperty('--bg', '#1a1a1a');
        root.style.setProperty('--sidebar', '#222222');
        root.style.setProperty('--card', '#2d2d2d');
        root.style.setProperty('--muted', '#b0b0b0');
        root.style.setProperty('--border', '#3a3a3a');
        root.style.setProperty('--badge', '#3a3a3a');
        document.body.style.color = '#ffffff';
      } else {
        root.style.setProperty('--bg', '#f6f8f6');
        root.style.setProperty('--sidebar', '#ecf2ec');
        root.style.setProperty('--card', '#ffffff');
        root.style.setProperty('--muted', '#6b7280');
        root.style.setProperty('--border', '#e8efe8');
        root.style.setProperty('--badge', '#e8efe5');
        document.body.style.color = '#1f2a1f';
      }
    }

    // Permission toggle handlers
    permissionToggles.camera?.addEventListener('click', function() {
      const isOn = !this.classList.contains('on');
      updateToggle(this, isOn);
      localStorage.setItem('cameraEnabled', isOn);
    });

    permissionToggles.microphone?.addEventListener('click', function() {
      const isOn = !this.classList.contains('on');
      updateToggle(this, isOn);
      localStorage.setItem('micEnabled', isOn);
    });

    permissionToggles.notifications?.addEventListener('click', function() {
      const isOn = !this.classList.contains('on');
      updateToggle(this, isOn);
      localStorage.setItem('notificationsEnabled', isOn);
    });

    permissionToggles.dailyReminder?.addEventListener('click', function() {
      const isOn = !this.classList.contains('on');
      updateToggle(this, isOn);
      localStorage.setItem('dailyReminderEnabled', isOn);
    });

    permissionToggles.smartReminders?.addEventListener('click', function() {
      const isOn = !this.classList.contains('on');
      updateToggle(this, isOn);
      localStorage.setItem('smartRemindersEnabled', isOn);
    });

    // Theme selection handlers
    themePills.forEach((pill, index) => {
      pill.addEventListener('click', function() {
        themePills.forEach(p => p.classList.remove('active'));
        this.classList.add('active');
        
        const theme = index === 0 ? 'light' : index === 1 ? 'dark' : 'auto';
        localStorage.setItem('theme', theme);
        applyTheme(theme);
      });
    });

    // Data export
    document.querySelectorAll('.grid-2')[1].querySelectorAll('.row')[0].addEventListener('click', async function() {
      try {
        const res = await fetch('api/get_month_moods.php?year=' + new Date().getFullYear() + '&month=' + (new Date().getMonth() + 1));
        const data = await res.json();
        const csv = 'Date,Mood Score,Face Emotion,Audio Emotion\n' + 
          data.moods.map(m => `${m.date},${m.combined_score},${m.face_emotion || '—'},${m.audio_emotion || '—'}`).join('\n');
        
        // Show in modal instead of downloading
        const modal = document.createElement('div');
        modal.style.cssText = 'position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;z-index:9999';
        modal.innerHTML = `
          <div style="background:#fff;border-radius:16px;padding:24px;max-width:600px;width:90%;max-height:70vh;overflow-y:auto;">
            <h3 style="margin-bottom:16px;font-size:18px;font-weight:700;">Mood Data (CSV)</h3>
            <textarea readonly style="width:100%;height:300px;padding:12px;border:1px solid #ddd;border-radius:8px;font-family:monospace;font-size:12px;">${csv}</textarea>
            <div style="margin-top:16px;display:flex;gap:10px;">
              <button style="flex:1;padding:10px;background:#7c9d85;color:#fff;border:none;border-radius:8px;cursor:pointer;font-weight:600;">Close</button>
              <button style="flex:1;padding:10px;background:#6a8b74;color:#fff;border:none;border-radius:8px;cursor:pointer;font-weight:600;">Copy to Clipboard</button>
            </div>
          </div>
        `;
        document.body.appendChild(modal);
        
        // Add event listeners after modal is added
        const textarea = modal.querySelector('textarea');
        modal.querySelectorAll('button')[0].addEventListener('click', () => modal.remove());
        modal.querySelectorAll('button')[1].addEventListener('click', () => {
          navigator.clipboard.writeText(textarea.value).then(() => alert('Copied to clipboard!'));
        });
      } catch (e) {
        alert('Could not export data');
      }
    });

    // Download data
    document.querySelectorAll('.grid-2')[1].querySelectorAll('.row')[1].addEventListener('click', async function() {
      try {
        const res = await fetch('api/get_month_moods.php?year=' + new Date().getFullYear() + '&month=' + (new Date().getMonth() + 1));
        const data = await res.json();
        const json = JSON.stringify(data, null, 2);
        
        // Show in modal instead of downloading
        const modal = document.createElement('div');
        modal.style.cssText = 'position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;z-index:9999';
        modal.innerHTML = `
          <div style="background:#fff;border-radius:16px;padding:24px;max-width:600px;width:90%;max-height:70vh;overflow-y:auto;">
            <h3 style="margin-bottom:16px;font-size:18px;font-weight:700;">Mood Data (JSON)</h3>
            <textarea readonly style="width:100%;height:300px;padding:12px;border:1px solid #ddd;border-radius:8px;font-family:monospace;font-size:12px;">${json}</textarea>
            <div style="margin-top:16px;display:flex;gap:10px;">
              <button style="flex:1;padding:10px;background:#7c9d85;color:#fff;border:none;border-radius:8px;cursor:pointer;font-weight:600;">Close</button>
              <button style="flex:1;padding:10px;background:#6a8b74;color:#fff;border:none;border-radius:8px;cursor:pointer;font-weight:600;">Copy to Clipboard</button>
            </div>
          </div>
        `;
        document.body.appendChild(modal);
        
        // Add event listeners after modal is added
        const textarea = modal.querySelector('textarea');
        modal.querySelectorAll('button')[0].addEventListener('click', () => modal.remove());
        modal.querySelectorAll('button')[1].addEventListener('click', () => {
          navigator.clipboard.writeText(textarea.value).then(() => alert('Copied to clipboard!'));
        });
      } catch (e) {
        alert('Could not download data');
      }
    });

    async function updateAuthSection() {
      try {
        const response = await fetch('./api/auth_status.php', { credentials: 'include' });
        const data = await response.json();
        const userInfo = document.getElementById('userInfo');
        const authPrompt = document.getElementById('authPrompt');
        
        if (data.logged_in && data.user) {
          document.getElementById('username').textContent = data.user.username;
          userInfo.style.display = 'flex';
          authPrompt.style.display = 'none';
        } else {
          userInfo.style.display = 'none';
          authPrompt.style.display = 'block';
        }
      } catch (error) {
        console.error('Error checking auth status:', error);
        // Fallback: if you can see settings page, you're logged in
        document.getElementById('userInfo').style.display = 'flex';
        document.getElementById('authPrompt').style.display = 'none';
      }
    }

    // Apply settings on page load
    loadSettings();
  </script>
</body>
</html>

