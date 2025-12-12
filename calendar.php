<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: /login.php');
  exit;
}
// Standalone calendar view for the mood tracker UI
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Mood Calendar</title>
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
      --good:#fef7d1;
      --ok:#fef2d8;
      --low:#e8f1fd;
      --badge:#e8efe5;
    }

    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:Inter,system-ui,-apple-system,Segoe UI,sans-serif;background:var(--bg);color:#1f2a1f;display:flex;min-height:100vh;}

    /* Sidebar */
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

    .welcome{margin-top:auto;background:#f0f5f0;border:1px solid #dce6de;border-radius:12px;padding:12px;display:flex;align-items:center;gap:8px;font-size:13px;color:#1f2a1f}
    /* Main */
    .main{margin-left:250px;flex:1;padding:26px 34px;min-height:100vh}
    .header-title{font-size:30px;font-weight:700;margin-bottom:6px;color:#1f2a1f}
    .header-sub{color:#6b7280;font-size:15px}
    .page-head{margin-bottom:22px;}
    .page-title{font-size:30px;font-weight:700;letter-spacing:-0.02em;margin-bottom:6px;color:#1f2a1f;}
    .page-sub{color:var(--muted);font-size:15px;}

    .layout{display:grid;grid-template-columns:2.1fr 1fr;gap:24px;align-items:start;}
    .card{background:var(--card);border-radius:18px;box-shadow:0 6px 18px rgba(0,0,0,0.06);border:1px solid var(--border);}

    /* Calendar card */
    .calendar-card{padding:18px;}
    .calendar-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;}
    .calendar-title{font-size:18px;font-weight:700;color:#2d332e;}
    .chevrons{display:flex;gap:10px;}
    .chevron{width:34px;height:34px;border-radius:10px;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:16px;background:#f6f8f4;cursor:pointer;transition:all .2s;}
    .chevron:hover{background:#eef3ea;}

    .dow{display:grid;grid-template-columns:repeat(7,1fr);gap:8px;margin-bottom:8px;color:var(--muted);font-size:13px;font-weight:600;text-align:center;}
    .grid{display:grid;grid-template-columns:repeat(7,1fr);gap:8px;}
    .day{background:#f8f9f7;border:1px solid var(--border);border-radius:14px;min-height:82px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;padding:10px;font-weight:700;color:#2d332e;transition:all .2s;}
    .day.empty{background:transparent;border:none;box-shadow:none;}
    .day:hover:not(.empty){transform:translateY(-2px);box-shadow:0 8px 20px rgba(17,24,39,0.06);}
    .day.good{background:var(--good);}
    .day.ok{background:var(--ok);}
    .day.low{background:var(--low);}
    .mood{font-size:14px;}
    .mood strong{display:block;font-size:26px;}
    .pill{display:flex;align-items:center;gap:4px;font-size:12px;color:#59705c;background:#e8efe5;border-radius:16px;padding:3px 8px;font-weight:600;}
    .legend-dot{width:9px;height:9px;border-radius:50%;}

    /* Right column */
    .stack{display:flex;flex-direction:column;gap:16px;}
    .legend-card{padding:16px;}
    .legend-title{font-weight:700;font-size:16px;margin-bottom:12px;color:#2d332e;}
    .legend-list{display:grid;gap:10px;}
    .legend-item{display:flex;align-items:center;gap:10px;color:#2d332e;font-weight:600;font-size:14px;}
    .legend-icon{width:28px;height:28px;border-radius:8px;background:#f0f2ef;display:flex;align-items:center;justify-content:center;font-size:15px;}

    .quick-card{padding:16px;}
    .quick-title{font-weight:700;font-size:16px;margin-bottom:14px;}
    .quick-actions{display:flex;flex-direction:column;gap:10px;}
    .quick-btn{border:none;border-radius:14px;padding:12px 14px;font-size:14px;font-weight:700;display:flex;align-items:center;gap:10px;cursor:pointer;transition:all .2s;}
    .quick-btn.primary{background:var(--accent);color:#fff;}
    .quick-btn.secondary{background:#e8f4eb;color:#14301c;border:1px solid #d4e4d6;}
    .quick-btn:hover{transform:translateY(-1px);box-shadow:0 6px 14px rgba(17,24,39,0.08);}

    /* Post preview (Facebook-like) */
    .post-preview{border-radius:12px;border:1px solid var(--border);background:#fff;padding:12px;box-shadow:0 6px 18px rgba(0,0,0,0.04);} 
    .post-header{display:flex;gap:10px;align-items:center;margin-bottom:8px}
    .post-avatar{width:40px;height:40px;border-radius:50%;background:var(--accent);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700}
    .post-author{font-weight:700}
    .post-date{font-size:12px;color:var(--muted)}
    .post-body{margin-top:6px;white-space:pre-wrap}
    .post-media{margin-top:10px;border-radius:8px;overflow:hidden}
    .post-media img, .post-media video{width:100%;height:auto;display:block}

    @media(max-width:1100px){
      .layout{grid-template-columns:1fr;}
    }
    @media(max-width:768px){
      body{flex-direction:column;}
      .sidebar{position:relative;width:100%;flex-direction:row;flex-wrap:wrap;gap:10px;align-items:center;border-right:none;border-bottom:1px solid var(--border);}
      .nav{flex-direction:row;flex-wrap:wrap;}
      .content{margin-left:0;padding:20px;}
      .page-title{font-size:24px;}
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
      <a class="nav-item active" href="calendar.php"><span class="nav-icon">📅</span>Calendar</a>
      <a class="nav-item" href="daily-log.php"><span class="nav-icon">📖</span>Daily Log</a>
      <a class="nav-item" href="calming-tools.php"><span class="nav-icon">✨</span>Calming Tools</a>
      <a class="nav-item" href="flashcard.php"><span class="nav-icon">💬</span>Flashcards</a>
      <a class="nav-item" href="progress.php"><span class="nav-icon">📊</span>Progress</a>
      <a class="nav-item" href="settings.php"><span class="nav-icon">⚙️</span>Settings</a>
    </nav>
    <div class="welcome" id="authSection" style="flex-direction:column;align-items:stretch;gap:12px">
      <div id="userInfo" style="display:none">
        <div style="font-size:12px;color:#54625a">Logged in as</div>
        <div id="username" style="font-weight:700;color:#1f2a1f;margin-bottom:8px">—</div>
        <a href="logout.php" style="display:inline-block;padding:6px 12px;background:#6a8b74;color:#fff;border-radius:8px;font-size:12px;text-align:center">Log out</a>
      </div>
      <div id="authPrompt" style="text-align:center;gap:8px;display:flex;flex-direction:column">
        <div>Not logged in</div>
        <a href="login.php" style="padding:8px 12px;background:#7c9d85;color:#fff;border-radius:8px;font-size:13px;font-weight:600">Log in</a>
        <a href="register.php" style="padding:8px 12px;background:#e8efe8;color:#1f2a1f;border-radius:8px;font-size:13px;font-weight:600">Sign up</a>
      </div>
    </div>
  </aside>

  <main class="main">
    <div class="page-head">
      <div class="page-title">Mood Calendar</div>
      <div class="page-sub">View your mood history and patterns</div>
    </div>

    <div class="layout">
      <section class="calendar-card card">
        <div class="calendar-head">
          <div class="calendar-title" id="monthLabel">December 2024</div>
          <div class="chevrons">
            <button class="chevron" id="prevBtn">‹</button>
            <button class="chevron" id="nextBtn">›</button>
          </div>
        </div>

        <div class="dow">
          <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
        </div>
        <div class="grid" id="calendarGrid"></div>
      </section>

      <div class="stack">
        <div class="legend-card card">
          <div class="legend-title">Legend</div>
          <div class="legend-list">
            <div class="legend-item"><div class="legend-icon">📖</div>Diary Entry</div>
            <div class="legend-item"><div class="legend-icon">📹</div>Photo/Video</div>
            <div class="legend-item"><div class="legend-icon">🙂</div>Face Detected</div>
            <div class="legend-item"><div class="legend-icon">🎙️</div>Audio Detected</div>
          </div>
        </div>

        <div class="quick-card card">
          <div class="quick-title">Quick Actions</div>
          <div class="quick-actions">
              <button id="openToday" class="quick-btn primary">📖 Open Today's Log</button>
              <button id="openCalm" class="quick-btn secondary">🧘 Calming Tools</button>
            </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Diary preview modal (shown when opening a day with existing diary/media) -->
  <div id="diaryModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);align-items:center;justify-content:center;z-index:60">
    <div style="width:820px;max-width:92%;background:#fff;border-radius:12px;padding:18px;box-shadow:0 20px 50px rgba(0,0,0,0.3);position:relative">
      <button id="closeModal" style="position:absolute;right:12px;top:12px;border:none;background:#eee;border-radius:8px;padding:6px 8px;cursor:pointer">✕</button>
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
        <div style="font-weight:700;font-size:18px" id="modalDate">Date</div>
        <div style="display:flex;gap:8px">
          <button id="openFullEditor" class="quick-btn secondary" style="padding:8px 10px">✏️ Open Full Editor</button>
        </div>
      </div>
      <div id="modalPostPreview" class="post-preview" style="display:none;margin-bottom:12px"></div>
      <div style="display:flex;gap:18px">
        <div style="flex:1">
          <div style="font-weight:700;margin-bottom:8px">Diary</div>
          <div id="modalDiaryWrap">
            <div id="modalDiaryText" style="white-space:pre-wrap;background:#f6f8f6;padding:12px;border-radius:8px;border:1px solid #eef2ec;min-height:120px;color:#1f2a1f"></div>
          </div>
          <div style="display:flex;gap:8px;margin-top:8px">
            <button id="editModalDiary" class="quick-btn secondary" style="padding:8px 10px">Edit</button>
            <button id="saveModalDiary" class="quick-btn primary" style="padding:8px 10px;display:none">Save</button>
          </div>
        </div>
        <div style="width:260px">
          <div style="font-weight:700;margin-bottom:8px">Attachments</div>
          <div id="modalMediaList" style="display:flex;flex-direction:column;gap:8px;max-height:320px;overflow:auto"></div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const monthLabel = document.getElementById('monthLabel');
    const grid = document.getElementById('calendarGrid');
    let current = new Date();
    let moodMap = {}; // Will be populated from API

    function formatDate(date){
      // Use local date, not UTC
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const day = String(date.getDate()).padStart(2, '0');
      return `${year}-${month}-${day}`;
    }

    // Map combined score to emoji and color
    function getEmojiFromScore(score) {
      if (score >= 80) return { emoji: '😄', style: 'good' };
      if (score >= 60) return { emoji: '😊', style: 'good' };
      if (score >= 40) return { emoji: '🙂', style: 'ok' };
      if (score >= 20) return { emoji: '😐', style: 'ok' };
      return { emoji: '😢', style: 'low' };
    }

    async function loadMonthMoods() {
      try {
        const year = current.getFullYear();
        const month = String(current.getMonth() + 1).padStart(2, '0');
        const res = await fetch(`api/get_month_moods.php?year=${year}&month=${month}`);
        if (res.status === 401) return;
        const data = await res.json();
        
        moodMap = {};
        if (data.moods && Array.isArray(data.moods)) {
          data.moods.forEach(mood => {
            const moodInfo = getEmojiFromScore(mood.combined_score || 50);
            moodMap[mood.date] = {
              ...moodInfo,
              diary: mood.has_diary > 0,
              face: mood.face_emotion ? true : false,
              audio: mood.audio_emotion ? true : false,
              score: mood.combined_score
            };
          });
        }
        renderCalendar();
      } catch (e) {
        console.error('Error loading month moods:', e);
        renderCalendar();
      }
    }

    function renderCalendar(){
      const year = current.getFullYear();
      const month = current.getMonth();
      const start = new Date(year, month, 1);
      const end = new Date(year, month + 1, 0);
      const firstDay = start.getDay();
      const daysInMonth = end.getDate();

      const monthName = start.toLocaleDateString('en-US',{month:'long',year:'numeric'});
      monthLabel.textContent = monthName;

      grid.innerHTML = '';
      for(let i=0;i<firstDay;i++){
        const empty = document.createElement('div');
        empty.className='day empty';
        grid.appendChild(empty);
      }

      for(let d=1; d<=daysInMonth; d++){
        const cell = document.createElement('div');
        const date = new Date(year, month, d);
        const key = formatDate(date);
        const info = moodMap[key];
        cell.className = 'day' + (info ? ` ${info.style}` : '');
        cell.dataset.date = key;
        cell.innerHTML = `
          <div>${d}</div>
          ${info ? `<div class="mood"><strong>${info.emoji}</strong></div>
            <div class="pill">
              ${info.diary ? '<span class="legend-dot" style="background:#739d73"></span>' : ''}
              ${info.face ? '<span class="legend-dot" style="background:#f2ac57"></span>' : ''}
              ${info.audio ? '<span class="legend-dot" style="background:#78a3f7"></span>' : ''}
            </div>` : ''}
        `;
        grid.appendChild(cell);
      }
    }

    // Day click: show modal preview if diary exists, otherwise open daily-log for that date
    grid.addEventListener('click', async (e) => {
      const cell = e.target.closest('.day');
      if (!cell || cell.classList.contains('empty')) return;
      const date = cell.dataset.date;
      if (!date) return;
      const today = formatDate(new Date());
      if (date > today) {
        alert('You cannot add or edit logs for future dates.');
        return;
      }

      try {
        const res = await fetch(`api/get_daily_log.php?date=${date}`);
        if (res.status === 401) return;
        const data = await res.json();
        // If there's a diary or media, show modal preview; otherwise open full editor
        if ((data.diary && data.diary.content) || (data.media && data.media.length > 0)) {
          showDiaryModal(date, data);
        } else {
          window.location.href = `daily-log.php?date=${date}`;
        }
      } catch (err) {
        console.error('Error fetching daily log:', err);
        window.location.href = `daily-log.php?date=${date}`;
      }
    });

    document.getElementById('prevBtn').addEventListener('click',()=>{
      current.setMonth(current.getMonth()-1);
      loadMonthMoods();
    });
    document.getElementById('nextBtn').addEventListener('click',()=>{
      current.setMonth(current.getMonth()+1);
      loadMonthMoods();
    });

    // Update today's mood in sidebar
    async function updateTodayMood() {
      try {
        const res = await fetch('api/get_today_mood.php');
        if (res.status === 401) return;
        const data = await res.json();
        if (data.found && data.data) {
          const score = data.data.combined_score;
          let emoji = '😊';
          let text = 'Feeling good today';
          
          if (score >= 70) {
            emoji = '😄';
            text = 'Feeling great!';
          } else if (score >= 50) {
            emoji = '🙂';
            text = 'Feeling okay';
          } else if (score >= 30) {
            emoji = '😐';
            text = 'Feeling neutral';
          } else {
            emoji = '😢';
            text = 'Feeling low';
          }
          
          document.getElementById('todayMoodEmoji').textContent = emoji;
          document.getElementById('todayMoodText').textContent = text;
        }
      } catch (e) {
        console.error('Error loading today mood:', e);
      }
    }
    
    updateTodayMood();
    loadMonthMoods();
    
    // Modal helpers
    const diaryModal = document.getElementById('diaryModal');
    const modalDate = document.getElementById('modalDate');
    const modalMediaList = document.getElementById('modalMediaList');
    const closeModal = document.getElementById('closeModal');
    const editModalBtn = document.getElementById('editModalDiary');
    const saveModalBtn = document.getElementById('saveModalDiary');
    const openFullBtn = document.getElementById('openFullEditor');

    closeModal.addEventListener('click', hideDiaryModal);
    diaryModal.addEventListener('click', (ev) => { if (ev.target === diaryModal) hideDiaryModal(); });

    function hideDiaryModal(){ diaryModal.style.display = 'none'; const m = document.getElementById('modalDiaryText'); if (m) m.innerHTML = ''; const mm = document.getElementById('modalMediaList'); if (mm) mm.innerHTML = ''; }

    function showDiaryModal(date, data){
      modalDate.textContent = new Date(date).toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
      // diary text
      const mdt = document.getElementById('modalDiaryText');
      if (mdt) {
        if (data.diary && data.diary.content) {
          mdt.textContent = data.diary.content;
          mdt.dataset.diaryId = data.diary.id || '';
        } else {
          mdt.textContent = '(No diary content)';
          mdt.dataset.diaryId = '';
        }
      }

      // hide post-style preview (not using this design)
      const modalPost = document.getElementById('modalPostPreview');
      if (modalPost) {
        modalPost.style.display = 'none';
        modalPost.innerHTML = '';
      }

      // media: show a large preview of the first attachment in the right box, list others below
      modalMediaList.innerHTML = '';
      if (data.media && data.media.length > 0) {
        const first = data.media[0];
        const previewWrap = document.createElement('div');
        previewWrap.style.marginBottom = '8px';
        if (first.media_type && first.media_type.startsWith('image')) {
          const img = document.createElement('img');
          img.src = first.file_path;
          img.style.width = '100%';
          img.style.borderRadius = '8px';
          img.alt = 'attachment';
          previewWrap.appendChild(img);
        } else if (first.media_type && first.media_type.startsWith('video')) {
          const vid = document.createElement('video');
          vid.src = first.file_path;
          vid.controls = true;
          vid.style.width = '100%';
          vid.style.borderRadius = '8px';
          previewWrap.appendChild(vid);
        }
        modalMediaList.appendChild(previewWrap);

        // list all attachments (including first) as links below the preview
        data.media.forEach(m => {
          const row = document.createElement('div');
          row.style.display = 'flex';
          row.style.flexDirection = 'column';
          row.style.gap = '6px';
          const a = document.createElement('a');
          a.href = m.file_path;
          a.textContent = m.file_path.split('/').pop() || 'Attachment';
          a.target = '_blank';
          row.appendChild(a);
          modalMediaList.appendChild(row);
        });
      } else {
        modalMediaList.innerHTML = '<div style="color:var(--muted)">No attachments</div>';
      }

      // wire buttons
      editModalBtn.style.display = 'inline-block';
      saveModalBtn.style.display = 'none';
      openFullBtn.onclick = () => { window.location.href = `daily-log.php?date=${date}`; };

      editModalBtn.onclick = () => {
        // turn into editable textarea
        const modalTextEl = document.getElementById('modalDiaryText');
        const txt = modalTextEl ? modalTextEl.textContent : '';
        const ta = document.createElement('textarea');
        ta.id = 'modalDiaryTextarea';
        ta.style.width = '100%';
        ta.style.minHeight = '120px';
        ta.value = txt;
        const wrap = document.getElementById('modalDiaryWrap');
        const existing = document.getElementById('modalDiaryText');
        if (existing) wrap.replaceChild(ta, existing);
        saveModalBtn.style.display = 'inline-block';
        editModalBtn.style.display = 'none';
      };

      saveModalBtn.onclick = async () => {
        const ta = document.getElementById('modalDiaryTextarea');
        if (!ta) return;
        const content = ta.value.trim();
        const diaryEl = document.getElementById('modalDiaryText');
        const diaryId = diaryEl ? (diaryEl.dataset.diaryId || '') : '';
        try {
          const res = await fetch('api/save_diary.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `content=${encodeURIComponent(content)}&date=${date}`
          });
          const r = await res.json();
          if (!r.ok) throw new Error(r.error || 'Save failed');
          // replace textarea with updated div
          const newDiv = document.createElement('div');
          newDiv.id = 'modalDiaryText';
          newDiv.style.whiteSpace = 'pre-wrap';
          newDiv.style.background = '#f6f8f6';
          newDiv.style.padding = '12px';
          newDiv.style.borderRadius = '8px';
          newDiv.style.border = '1px solid #eef2ec';
          newDiv.textContent = content;
          newDiv.dataset.diaryId = r.id || '';
          const wrap = document.getElementById('modalDiaryWrap');
          wrap.replaceChild(newDiv, document.getElementById('modalDiaryTextarea'));
          saveModalBtn.style.display = 'none';
          editModalBtn.style.display = 'inline-block';
          // refresh month moods (in case diary indicator changed)
          loadMonthMoods();
        } catch (err) {
          alert('Error saving diary: ' + err.message);
        }
      };

      diaryModal.style.display = 'flex';
    }
    // Wire quick action buttons
    document.getElementById('openToday')?.addEventListener('click', () => {
      const today = formatDate(new Date());
      window.location.href = `daily-log.php?date=${today}`;
    });
    document.getElementById('openCalm')?.addEventListener('click', () => {
      window.location.href = 'calming-tools.php';
    });
  </script>

  <script>
    async function updateAuthSection() {
      try {
        const response = await fetch('./api/auth_status.php');
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
      }
    }

    function logout() {
      fetch('./api/logout.php', { method: 'POST' })
        .then(() => {
          window.location.href = './login.php';
        })
        .catch(error => console.error('Error logging out:', error));
    }

    updateAuthSection();
  </script>
</body>
</html>

