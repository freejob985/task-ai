<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة المهام والمشاريع</title>
    <!-- Bootstrap RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Noto Kufi Arabic Font -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet">
    <!-- Tagify CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Kufi Arabic', sans-serif;
            background-color: #f8f9fa;
        }
        .task-list {
            max-width: 1200px;
            margin: 2rem auto;
        }
        .tagify {
            width: 100%;
        }
        .task-row {
            cursor: move;
            transition: background-color 0.3s ease;
        }
        .timer-running {
            animation: blink 1s infinite;
        }
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            margin-bottom: 20px;
        }
        .card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
        }
        .table {
            border-collapse: separate;
            border-spacing: 0;
        }
        .table thead th {
            background-color: #f1f3f5;
            color: #495057;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px;
            border-bottom: 2px solid #dee2e6;
        }
        .table tbody td {
            padding: 15px;
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }
        /* Smooth scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
        .progress {
            height: 20px;
            margin-bottom: 10px;
        }
        .progress-bar {
            font-size: 14px;
            line-height: 20px;
        }
        #project-preview {
            width: 100%;
            height: 100px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        #sidebar {
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100%;
            background-color: #fff;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease;
            z-index: 1000;
            padding: 20px;
            overflow-y: auto;
            padding-top: 60px;
            max-height: 100vh;
        }
        #sidebar.active {
            right: 0;
        }
        #sidebar-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1002;
        }
        .filter-section {
            margin-bottom: 20px;
        }
        .filter-section h5 {
            margin-bottom: 10px;
        }
        .filter-checkbox {
            margin-bottom: 5px;
        }
        #statistics {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .project-color-dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 5px;
        }
        .filter-btn {
            margin-right: 5px;
            margin-bottom: 10px;
        }
        .filter-btn.active {
            background-color: #007bff;
            color: white;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        .completed-task {
            text-decoration: line-through;
            font-weight: 600;
        }
        .starred-task {
            color: #ffc107;
        }
        .priority-high {
            background-color: #dc3545;
            color: white;
        }
        .priority-medium {
            background-color: #ffc107;
            color: black;
        }
        .priority-low {
            background-color: #28a745;
            color: white;
        }
        .task-name.completed-task {
            text-decoration: line-through;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="task-list">
            <h1 class="text-center mb-4">نظام إدارة المهام والمشاريع</h1>
            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#projectModal">
                    <i class="fas fa-plus"></i> إضافة مشروع
                </button>
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#statusModal">
                    <i class="fas fa-tasks"></i> إدارة الحالات
                </button>
                <button class="btn btn-danger" id="clear-all-data">
                    <i class="fas fa-trash-alt"></i> حذف كل البيانات
                </button>
                <button class="btn btn-info" id="sidebar-toggle">
                    <i class="fas fa-filter"></i> الفلترة
                </button>
            </div>
            <div id="project-container" class="row">
                <!-- المشاريع ستضاف هنا ديناميكيًا -->
            </div>
            <div id="starred-tasks-container" class="mt-4">
                <h2>المهام المميزة</h2>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>المشروع</th>
                            <th>المهمة</th>
                            <th>الحالة</th>
                            <th>الأولوية</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="starred-tasks-list">
                        <!-- المهام المميزة ستضاف هنا ديناميكيًا -->
                    </tbody>
                </table>
            </div>
            <nav aria-label="Project navigation">
                <ul class="pagination" id="pagination">
                    <!-- أزرار الصفحات ستضاف هنا ديناميكيًا -->
                </ul>
            </nav>
        </div>
    </div>

    <!-- Modal إضافة مشروع -->
    <div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="projectModalLabel">إضافة مشروع جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="project-form">
                        <div class="mb-3">
                            <label for="project-name" class="form-label">اسم المشروع</label>
                            <input type="text" class="form-control" id="project-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="project-color" class="form-label">لون المشروع</label>
                            <input type="color" class="form-control" id="project-color" required>
                        </div>
                        <div id="project-preview"></div>
                        <button type="submit" class="btn btn-primary mt-3">إضافة المشروع</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal إضافة مهمة -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">إضافة مهمة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="task-form">
                        <input type="hidden" id="project-id">
                        <input type="hidden" id="task-id">
                        <div class="mb-3">
                            <label for="task-name" class="form-label">اسم المهمة</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="task-name" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="toggleSpeechRecognition(this)">
                                    <i class="material-icons">mic</i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="task-description" class="form-label">وصف المهمة</label>
                            <div class="input-group">
                                <textarea class="form-control" id="task-description" rows="3"></textarea>
                                <button class="btn btn-outline-secondary" type="button" onclick="toggleSpeechRecognition(this)">
                                    <i class="material-icons">mic</i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="task-status" class="form-label">حالة المهمة</label>
                            <select class="form-select" id="task-status" required>
                                <!-- الحالات ستضاف هنا ديناميكيًا -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="task-priority" class="form-label">أولوية المهمة</label>
                            <select class="form-select" id="task-priority" required>
                                <option value="low">منخفضة</option>
                                <option value="medium">متوسطة</option>
                                <option value="high">عالية</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="task-tags" class="form-label">الوسوم</label>
                            <input type="text" class="form-control" id="task-tags">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="task-starred">
                            <label class="form-check-label" for="task-starred">مهمة مميزة</label>
                        </div>
                        <button type="submit" class="btn btn-primary">حفظ المهمة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal إدارة الحالات -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">إدارة الحالات</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="status-form" class="mb-3">
                        <div class="mb-3">
                            <label for="status-name" class="form-label">اسم الحالة</label>
                            <input type="text" class="form-control" id="status-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="status-color" class="form-label">لون الحالة</label>
                            <input type="color" class="form-control" id="status-color" required>
                        </div>
                        <button type="submit" class="btn btn-primary">إضافة الحالة</button>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الحالة</th>
                                <th>اللون</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody id="status-list">
                            <!-- الحالات ستضاف هنا ديناميكيًا -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar للفلترة -->
    <div id="sidebar">
        <h4>الفلترة</h4>
        <div class="filter-section">
            <h5>المشاريع</h5>
            <div id="project-filters">
                <!-- فلاتر المشاريع ستضاف هنا ديناميكيًا -->
            </div>
        </div>
        <div class="filter-section">
            <h5>الحالات</h5>
            <div id="status-filters">
                <!-- فلاتر الحالات ستضاف هنا ديناميكيًا -->
            </div>
        </div>
        <div class="filter-section">
            <h5>الأولويات</h5>
            <div id="priority-filters">
                <div class="form-check filter-checkbox">
                    <input class="form-check-input priority-filter" type="checkbox" value="high" id="priority-high" checked>
                    <label class="form-check-label" for="priority-high">عالية</label>
                </div>
                <div class="form-check filter-checkbox">
                    <input class="form-check-input priority-filter" type="checkbox" value="medium" id="priority-medium" checked>
                    <label class="form-check-label" for="priority-medium">متوسطة</label>
                </div>
                <div class="form-check filter-checkbox">
                    <input class="form-check-input priority-filter" type="checkbox" value="low" id="priority-low" checked>
                    <label class="form-check-label" for="priority-low">منخفضة</label>
                </div>
            </div>
        </div>
        <div class="filter-section">
            <h5>المهام المميزة</h5>
            <div class="form-check filter-checkbox">
                <input class="form-check-input" type="checkbox" id="starred-tasks-filter">
                <label class="form-check-label" for="starred-tasks-filter">إظهار المهام المميزة فقط</label>
            </div>
        </div>
        <div id="statistics">
            <h5>الإحصائيات</h5>
            <div id="stats-content">
                <!-- الإحصائيات ستضاف هنا ديناميكيًا -->
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tagify JS -->
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <!-- Sortable JS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <!-- Toastify JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const projectForm = document.getElementById('project-form');
            const taskForm = document.getElementById('task-form');
            const statusForm = document.getElementById('status-form');
            const projectContainer = document.getElementById('project-container');
            const starredTasksList = document.getElementById('starred-tasks-list');
            const projectNameInput = document.getElementById('project-name');
            const projectColorInput = document.getElementById('project-color');
            const projectPreview = document.getElementById('project-preview');
            const taskNameInput = document.getElementById('task-name');
            const taskDescriptionInput = document.getElementById('task-description');
            const taskStatusInput = document.getElementById('task-status');
            const taskPriorityInput = document.getElementById('task-priority');
            const taskTagsInput = document.getElementById('task-tags');
            const taskStarredInput = document.getElementById('task-starred');
            const projectIdInput = document.getElementById('project-id');
            const statusNameInput = document.getElementById('status-name');
            const statusColorInput = document.getElementById('status-color');
            const statusList = document.getElementById('status-list');
            const projectFilters = document.getElementById('project-filters');
            const statusFilters = document.getElementById('status-filters');
            const starredTasksFilter = document.getElementById('starred-tasks-filter');
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const clearAllDataBtn = document.getElementById('clear-all-data');
            const statsContent = document.getElementById('stats-content');
            const pagination = document.getElementById('pagination');
            const taskIdInput = document.getElementById('task-id');

            let projects = JSON.parse(localStorage.getItem('projects')) || [];
            let statuses = JSON.parse(localStorage.getItem('statuses')) || [
                { name: 'قيد الانتظار', color: '#ffc107' },
                { name: 'قيد التنفيذ', color: '#17a2b8' },
                { name: 'مكتملة', color: '#28a745' }
            ];
            let currentPage = 1;
            const projectsPerPage = 4;

            const tagify = new Tagify(taskTagsInput);

            function saveProjects() {
                localStorage.setItem('projects', JSON.stringify(projects));
            }

            function saveStatuses() {
                localStorage.setItem('statuses', JSON.stringify(statuses));
            }

            function showToast(message, type = 'info') {
                Toastify({
                    text: message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: 'center',
                    backgroundColor: type === 'success' ? "#4CAF50" : "#F44336",
                }).showToast();
            }

            function renderProjects() {
                projectContainer.innerHTML = '';
                const startIndex = (currentPage - 1) * projectsPerPage;
                const endIndex = startIndex + projectsPerPage;
                const currentProjects = projects.slice(startIndex, endIndex);

                currentProjects.forEach((project, projectIndex) => {
                    const actualIndex = startIndex + projectIndex;
                    const card = document.createElement('div');
                    card.className = 'col-md-12 mb-4';
                    card.innerHTML = `
                        <div class="card">
                            <div class="card-header" style="background-color: ${project.color}; color: ${getContrastColor(project.color)};">
                                <h5 class="card-title mb-0">${project.name}</h5>
                            </div>
                            <div class="card-body">
                                <div class="progress mb-3">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#taskModal" data-project-id="${actualIndex}">
                                    <i class="fas fa-plus"></i> إضافة مهمة
                                </button>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>المهمة</th>
                                            <th>الحالة</th>
                                            <th>الأولوية</th>
                                            <th>الوقت</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody class="task-list" data-project-id="${actualIndex}">
                                        ${project.tasks.map((task, taskIndex) => `
                                            <tr data-status="${task.status}" data-priority="${task.priority}" class="task-row ${task.status === 'مكتملة' ? 'completed-task' : ''}">
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input task-complete-checkbox" type="checkbox" ${task.status === 'مكتملة' ? 'checked' : ''} data-project-id="${actualIndex}" data-task-id="${taskIndex}">
                                                        <label class="form-check-label task-name ${task.status === 'مكتملة' ? 'completed-task' : ''}">
                                                            ${task.name}
                                                            ${task.starred ? '<i class="fas fa-star text-warning"></i>' : ''}
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><span class="badge" style="background-color: ${getStatusColor(task.status)}">${task.status}</span></td>
                                                <td><span class="badge priority-${task.priority}">${getPriorityText(task.priority)}</span></td>
                                                <td>
                                                    <span class="timer">${formatTime(task.totalTime || 0)}</span>
                                                    <button class="btn btn-sm btn-outline-primary timer-btn" data-project-id="${actualIndex}" data-task-id="${taskIndex}">
                                                        <i class="fas fa-play"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info edit-task-btn" data-project-id="${actualIndex}" data-task-id="${taskIndex}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-task-btn" data-project-id="${actualIndex}" data-task-id="${taskIndex}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-secondary copy-task-btn" data-project-id="${actualIndex}" data-task-id="${taskIndex}">
                                                        <i class="fas fa-copy"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-warning star-task-btn" data-project-id="${actualIndex}" data-task-id="${taskIndex}">
                                                        <i class="fas ${task.starred ? 'fa-star' : 'fa-star-o'}"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                    projectContainer.appendChild(card);

                    // Initialize Sortable for the task list
                    new Sortable(card.querySelector('.task-list'), {
                        animation: 150,
                        ghostClass: 'blue-background-class',
                        onEnd: function (evt) {
                            const projectId = evt.target.getAttribute('data-project-id');
                            const oldIndex = evt.oldIndex;
                            const newIndex = evt.newIndex;
                            const task = projects[projectId].tasks.splice(oldIndex, 1)[0];
                            projects[projectId].tasks.splice(newIndex, 0, task);
                            saveProjects();
                            renderProjects();
                            applyFilters();
                        }
                    });
                });

                renderPagination();
                updateProgressBars();
                renderStarredTasks();

                document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#taskModal"]').forEach(btn => {
                    btn.addEventListener('click', function() {
                        projectIdInput.value = this.dataset.projectId;
                        taskNameInput.value = '';
                        taskDescriptionInput.value = '';
                        taskStatusInput.value = statuses[0].name;
                        taskPriorityInput.value = 'low';
                        tagify.removeAllTags();
                        taskStarredInput.checked = false;
                        taskIdInput.value = '';
                    });
                });

                document.querySelectorAll('.timer-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const projectId = this.dataset.projectId;
                        const taskId = this.dataset.taskId;
                        const task = projects[projectId].tasks[taskId];
                        const timerSpan = this.parentElement.querySelector('.timer');
                        const timerBtn = this;

                        if (!task.timerRunning) {
                            task.timerRunning = true;
                            task.timerStart = Date.now() - (task.totalTime || 0);
                            timerBtn.innerHTML = '<i class="fas fa-pause"></i>';
                            timerBtn.classList.add('btn-warning');
                            timerSpan.classList.add('timer-running');

                            task.timerInterval = setInterval(() => {
                                const elapsedTime = Date.now() - task.timerStart;
                                timerSpan.textContent = formatTime(elapsedTime);
                            }, 1000);
                        } else {
                            task.timerRunning = false;
                            clearInterval(task.timerInterval);
                            task.totalTime = Date.now() - task.timerStart;
                            timerBtn.innerHTML = '<i class="fas fa-play"></i>';
                            timerBtn.classList.remove('btn-warning');
                            timerSpan.classList.remove('timer-running');
                        }

                        saveProjects();
                    });
                });

                document.querySelectorAll('.edit-task-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const projectId = this.dataset.projectId;
                        const taskId = this.dataset.taskId;
                        const task = projects[projectId].tasks[taskId];

                        projectIdInput.value = projectId;
                        taskNameInput.value = task.name;
                        taskDescriptionInput.value = task.description;
                        taskStatusInput.value = task.status;
                        taskPriorityInput.value = task.priority;
                        tagify.removeAllTags();
                        tagify.addTags(task.tags);
                        taskStarredInput.checked = task.starred;
                        taskIdInput.value = taskId;

                        const taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
                        taskModal.show();
                    });
                });

                document.querySelectorAll('.delete-task-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        if (confirm('هل أنت متأكد من حذف هذه المهمة؟')) {
                            const projectId = this.dataset.projectId;
                            const taskId = this.dataset.taskId;
                            projects[projectId].tasks.splice(taskId, 1);
                            saveProjects();
                            renderProjects();
                            applyFilters();
                            showToast('تم حذف المهمة', 'success');
                        }
                    });
                });

                document.querySelectorAll('.copy-task-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const projectId = this.dataset.projectId;
                        const taskId = this.dataset.taskId;
                        const task = projects[projectId].tasks[taskId];
                        
                        navigator.clipboard.writeText(task.name).then(() => {
                            showToast('تم نسخ اسم المهمة', 'success');
                        }, () => {
                            showToast('فشل نسخ اسم المهمة', 'error');
                        });
                    });
                });

                document.querySelectorAll('.star-task-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const projectId = this.dataset.projectId;
                        const taskId = this.dataset.taskId;
                        const task = projects[projectId].tasks[taskId];
                        task.starred = !task.starred;
                        saveProjects();
                        renderProjects();
                        applyFilters();
                        showToast(task.starred ? 'تم تمييز المهمة' : 'تم إلغاء تمييز المهمة', 'success');
                    });
                });

                document.querySelectorAll('.task-complete-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const projectId = this.dataset.projectId;
                        const taskId = this.dataset.taskId;
                        const task = projects[projectId].tasks[taskId];
                        task.status = this.checked ? 'مكتملة' : 'قيد الانتظار';
                        saveProjects();
                        renderProjects();
                        applyFilters();
                    });
                });
            }

            function formatTime(ms) {
                if (isNaN(ms) || ms < 0) {
                    return '00:00:00';
                }
                const hours = Math.floor(ms / 3600000);
                const minutes = Math.floor((ms % 3600000) / 60000);
                const seconds = Math.floor((ms % 60000) / 1000);
                return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }

            function renderStatuses() {
                statusList.innerHTML = '';
                statusFilters.innerHTML = '';
                taskStatusInput.innerHTML = '';
                statuses.forEach((status, index) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${status.name}</td>
                        <td><span class="badge" style="background-color: ${status.color}">${status.color}</span></td>
                        <td>
                            <button class="btn btn-sm btn-danger delete-status-btn" data-index="${index}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    statusList.appendChild(tr);

                    const filterCheckbox = document.createElement('div');
                    filterCheckbox.className = 'form-check filter-checkbox';
                    filterCheckbox.innerHTML = `
                        <input class="form-check-input status-filter" type="checkbox" value="${status.name}" id="status-${index}" checked>
                        <label class="form-check-label" for="status-${index}">${status.name}</label>
                    `;
                    statusFilters.appendChild(filterCheckbox);

                    const option = document.createElement('option');
                    option.value = status.name;
                    option.textContent = status.name;
                    taskStatusInput.appendChild(option);
                });

                document.querySelectorAll('.delete-status-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = this.dataset.index;
                        statuses.splice(index, 1);
                        saveStatuses();
                        renderStatuses();
                        renderProjects();
                        applyFilters();
                        showToast('تم حذف الحالة', 'success');
                    });
                });

                document.querySelectorAll('.status-filter').forEach(checkbox => {
                    checkbox.addEventListener('change', applyFilters);
                });
            }

            function renderPagination() {
                const totalPages = Math.ceil(projects.length / projectsPerPage);
                pagination.innerHTML = '';
                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement('li');
                    li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                    li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
                    pagination.appendChild(li);
                }

                pagination.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        currentPage = parseInt(this.dataset.page);
                        renderProjects();
                        applyFilters();
                    });
                });
            }

            function updateProgressBars() {
                projects.forEach((project, projectIndex) => {
                    const progressBar = document.querySelector(`.card:nth-child(${projectIndex + 1}) .progress-bar`);
                    if (progressBar) {
                        const totalTasks = project.tasks.length;
                        const completedTasks = project.tasks.filter(task => task.status === 'مكتملة').length;
                        const percentage = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;
                        progressBar.style.width = `${percentage}%`;
                        progressBar.setAttribute('aria-valuenow', percentage);
                        progressBar.textContent = `${percentage}%`;
                    }
                });
            }

            function getContrastColor(hexcolor) {
                if (!hexcolor) return '#000000';
                hexcolor = hexcolor.replace("#", "");
                var r = parseInt(hexcolor.substr(0,2),16);
                var g = parseInt(hexcolor.substr(2,2),16);
                var b = parseInt(hexcolor.substr(4,2),16);
                var yiq = ((r*299)+(g*587)+(b*114))/1000;
                return (yiq >= 128) ? 'black' : 'white';
            }

            function getStatusColor(statusName) {
                const status = statuses.find(s => s.name === statusName);
                return status ? status.color : '#ffffff';
            }

            function getPriorityText(priority) {
                switch (priority) {
                    case 'high': return 'عالية';
                    case 'medium': return 'متوسطة';
                    case 'low': return 'منخفضة';
                    default: return '';
                }
            }

            function renderProjectFilters() {
                projectFilters.innerHTML = '';
                projects.forEach((project, index) => {
                    const filterCheckbox = document.createElement('div');
                    filterCheckbox.className = 'form-check filter-checkbox';
                    filterCheckbox.innerHTML = `
                        <input class="form-check-input project-filter" type="checkbox" value="${project.name}" id="project-${index}" checked>
                        <label class="form-check-label" for="project-${index}">
                            <span class="project-color-dot" style="background-color: ${project.color};"></span>
                            ${project.name}
                        </label>
                    `;
                    projectFilters.appendChild(filterCheckbox);
                });

                const selectAllBtn = document.createElement('button');
                selectAllBtn.className = 'btn btn-sm btn-outline-secondary mt-2 me-2 filter-btn';
                selectAllBtn.textContent = 'تحديد الكل';
                selectAllBtn.addEventListener('click', () => {
                    document.querySelectorAll('.project-filter').forEach(cb => cb.checked = true);
                    applyFilters();
                    showToast('تم تحديد جميع المشاريع', 'success');
                });

                const deselectAllBtn = document.createElement('button');
                deselectAllBtn.className = 'btn btn-sm btn-outline-secondary mt-2 filter-btn';
                deselectAllBtn.textContent = 'إلغاء تحديد الكل';
                deselectAllBtn.addEventListener('click', () => {
                    document.querySelectorAll('.project-filter').forEach(cb => cb.checked = false);
                    applyFilters();
                    showToast('تم إلغاء تحديد جميع المشاريع', 'success');
                });

                projectFilters.appendChild(selectAllBtn);
                projectFilters.appendChild(deselectAllBtn);

                document.querySelectorAll('.project-filter').forEach(checkbox => {
                    checkbox.addEventListener('change', applyFilters);
                });
            }

            function applyFilters() {
                const selectedProjects = Array.from(document.querySelectorAll('.project-filter:checked')).map(cb => cb.value);
                const selectedStatuses = Array.from(document.querySelectorAll('.status-filter:checked')).map(cb => cb.value);
                const selectedPriorities = Array.from(document.querySelectorAll('.priority-filter:checked')).map(cb => cb.value);
                const showStarredOnly = document.getElementById('starred-tasks-filter').checked;

                document.querySelectorAll('.card').forEach(card => {
                    const projectName = card.querySelector('.card-title').textContent;
                    const isProjectVisible = selectedProjects.includes(projectName);
                    card.style.display = isProjectVisible ? 'block' : 'none';

                    if (isProjectVisible) {
                        card.querySelectorAll('tbody tr').forEach(row => {
                            const status = row.getAttribute('data-status');
                            const priority = row.getAttribute('data-priority');
                            const isStarred = row.querySelector('.fa-star') !== null;
                            const isVisible = selectedStatuses.includes(status) &&
                                              selectedPriorities.includes(priority) &&
                                              (!showStarredOnly || isStarred);
                            row.style.display = isVisible ? 'table-row' : 'none';
                        });
                    }
                });

                updateStatistics();
                renderStarredTasks();
            }
function renderStarredTasks() {
    const starredTasksContainer = document.getElementById('starred-tasks-container');
    starredTasksContainer.innerHTML = '';

    const starredTasks = projects.flatMap((project, projectIndex) => 
        project.tasks
            .filter(task => task.starred)
            .map((task, taskIndex) => ({ ...task, projectName: project.name, projectId: projectIndex, taskId: taskIndex }))
    );

    const table = document.createElement('table');
    table.className = 'table table-hover';
    table.innerHTML = `
        <thead>
            <tr>
                <th>تم</th>
                <th>المشروع</th>
                <th>المهمة</th>
                <th>الحالة</th>
                <th>الأولوية</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody id="starred-tasks-tbody">
            ${starredTasks.length > 0 ? starredTasks.map(task => `
                <tr data-project-id="${task.projectId}" data-task-id="${task.taskId}" class="${task.status === 'مكتملة' ? 'completed-task' : ''} task-row">
                    <td>
                        <input type="checkbox" class="form-check-input starred-task-checkbox" ${task.status === 'مكتملة' ? 'checked' : ''}>
                    </td>
                    <td>${task.projectName}</td>
                    <td class="${task.status === 'مكتملة' ? 'completed-task' : ''}">${task.name}</td>
                    <td><span class="badge" style="background-color: ${getStatusColor(task.status)}">${task.status}</span></td>
                    <td><span class="badge priority-${task.priority}">${getPriorityText(task.priority)}</span></td>
                    <td>
                        <button class="btn btn-sm btn-info edit-starred-task-btn" data-project-id="${task.projectId}" data-task-id="${task.taskId}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-warning unstar-task-btn" data-project-id="${task.projectId}" data-task-id="${task.taskId}">
                            <i class="fas fa-star"></i>
                        </button>
                    </td>
                </tr>
            `).join('') : `
                <tr>
                    <td colspan="6" class="text-center">لا توجد مهام مميزة حاليًا.</td>
                </tr>
            `}
        </tbody>
    `;
    starredTasksContainer.appendChild(table);

    if (starredTasks.length > 0) {
        // Initialize Sortable for the starred tasks table
        new Sortable(document.getElementById('starred-tasks-tbody'), {
            animation: 150,
            ghostClass: 'blue-background-class',
            handle: '.task-row', // This allows dragging by the entire row
            onEnd: function (evt) {
                const taskElement = evt.item;
                const projectId = taskElement.dataset.projectId;
                const taskId = taskElement.dataset.taskId;
                const newIndex = evt.newIndex;

                // Remove the task from its original position
                const task = projects[projectId].tasks.splice(taskId, 1)[0];

                // Find the new project and position
                const newProjectId = evt.to.children[newIndex].dataset.projectId;
                const newTaskId = evt.to.children[newIndex].dataset.taskId;

                // Insert the task at its new position
                projects[newProjectId].tasks.splice(newTaskId, 0, task);

                saveProjects();
                renderProjects();
                applyFilters();
                showToast('تم نقل المهمة بنجاح', 'success');
            }
        });

        // Add event listeners for edit and unstar buttons
        document.querySelectorAll('.edit-starred-task-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const projectId = this.dataset.projectId;
                const taskId = this.dataset.taskId;
                const task = projects[projectId].tasks[taskId];

                projectIdInput.value = projectId;
                taskNameInput.value = task.name;
                taskDescriptionInput.value = task.description;
                taskStatusInput.value = task.status;
                taskPriorityInput.value = task.priority;
                tagify.removeAllTags();
                tagify.addTags(task.tags);
                taskStarredInput.checked = task.starred;
                taskIdInput.value = taskId;

                const taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
                taskModal.show();
            });
        });

        document.querySelectorAll('.unstar-task-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                showToast('تم النقر على زر إلغاء التمييز', 'info');
            });
        });

        // Add event listeners for starred task checkboxes
        document.querySelectorAll('.starred-task-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const projectId = this.closest('tr').dataset.projectId;
                const taskId = this.closest('tr').dataset.taskId;
                const task = projects[projectId].tasks[taskId];
                task.status = this.checked ? 'مكتملة' : 'قيد الانتظار';
                saveProjects();
                renderProjects();
                applyFilters();
                showToast(this.checked ? 'تم تحويل المهمة إلى مكتملة' : 'تم تحويل المهمة إلى قيد الانتظار', 'success');
            });
        });
    }
}
            function updateStatistics() {
                const selectedProjects = Array.from(document.querySelectorAll('.project-filter:checked')).map(cb => cb.value);
                const selectedStatuses = Array.from(document.querySelectorAll('.status-filter:checked')).map(cb => cb.value);
                const selectedPriorities = Array.from(document.querySelectorAll('.priority-filter:checked')).map(cb => cb.value);
                const showStarredOnly = document.getElementById('starred-tasks-filter').checked;

                let totalTasks = 0;
                let completedTasks = 0;
                let totalTime = 0;
                let starredTasks = 0;
                const priorityCounts = { high: 0, medium: 0, low: 0 };

                projects.forEach(project => {
                    if (selectedProjects.includes(project.name)) {
                        project.tasks.forEach(task => {
                            if (selectedStatuses.includes(task.status) &&
                                selectedPriorities.includes(task.priority) &&
                                (!showStarredOnly || task.starred)) {
                                totalTasks++;
                                if (task.status === 'مكتملة') {
                                    completedTasks++;
                                }
                                totalTime += task.totalTime || 0;
                                if (task.starred) {
                                    starredTasks++;
                                }
                                priorityCounts[task.priority]++;
                            }
                        });
                    }
                });

                const completionRate = totalTasks > 0 ? (completedTasks / totalTasks * 100).toFixed(2) : 0;

                statsContent.innerHTML = `
                    <p><span class="badge bg-primary">إجمالي المهام: ${totalTasks}</span></p>
                    <p><span class="badge bg-success">المهام المكتملة: ${completedTasks}</span></p>
                    <p><span class="badge bg-info">نسبة الإنجاز: ${completionRate}%</span></p>
                    <p><span class="badge bg-warning">الوقت الإجمالي: ${formatTime(totalTime)}</span></p>
                    <p><span class="badge bg-secondary">المهام المميزة: ${starredTasks}</span></p>
                    <p>الأولويات:</p>
                    <p><span class="badge bg-danger">عالية: ${priorityCounts.high}</span></p>
                    <p><span class="badge bg-warning text-dark">متوسطة: ${priorityCounts.medium}</span></p>
                    <p><span class="badge bg-success">منخفضة: ${priorityCounts.low}</span></p>
                `;
            }

            projectForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const newProject = {
                    name: projectNameInput.value,
                    color: projectColorInput.value,
                    tasks: []
                };
                projects.push(newProject);
                saveProjects();
                renderProjects();
                renderProjectFilters();
                this.reset();
                const modal = bootstrap.Modal.getInstance(document.getElementById('projectModal'));
                modal.hide();
                showToast('تم إضافة المشروع بنجاح', 'success');
            });

            taskForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const projectId = projectIdInput.value;
                const taskId = taskIdInput.value;
                const newTask = {
                    name: taskNameInput.value,
                    description: taskDescriptionInput.value,
                    status: taskStatusInput.value,
                    priority: taskPriorityInput.value,
                    tags: tagify.value.map(tag => tag.value),
                    starred: taskStarredInput.checked,
                    totalTime: 0
                };

                if (taskId === '') {
                    // Add new task
                    projects[projectId].tasks.push(newTask);
                } else {
                    // Edit existing task
                    projects[projectId].tasks[taskId] = {
                        ...projects[projectId].tasks[taskId],
                        ...newTask
                    };
                }

                saveProjects();
                renderProjects();
                applyFilters();
                this.reset();
                tagify.removeAllTags();
                const modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
                modal.hide();
                showToast('تم حفظ المهمة بنجاح', 'success');
            });

            statusForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const newStatus = {
                    name: statusNameInput.value,
                    color: statusColorInput.value
                };
                statuses.push(newStatus);
                saveStatuses();
                renderStatuses();
                this.reset();
                showToast('تم إضافة الحالة بنجاح', 'success');
            });

            projectColorInput.addEventListener('input', function() {
                projectPreview.style.backgroundColor = this.value;
                projectPreview.style.color = getContrastColor(this.value);
                projectPreview.textContent = projectNameInput.value || 'معاينة المشروع';
            });

            projectNameInput.addEventListener('input', function() {
                projectPreview.textContent = this.value || 'معاينة المشروع';
            });

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });

            clearAllDataBtn.addEventListener('click', function() {
                if (confirm('هل أنت متأكد من حذف جميع البيانات؟ لا يمكن التراجع عن هذا الإجراء.')) {
                    localStorage.clear();
                    projects = [];
                    statuses = [
                        { name: 'قيد الانتظار', color: '#ffc107' },
                        { name: 'قيد التنفيذ', color: '#17a2b8' },
                        { name: 'مكتملة', color: '#28a745' }
                    ];
                    saveProjects();
                    saveStatuses();
                    renderProjects();
                    renderStatuses();
                    renderProjectFilters();
                    applyFilters();
                    showToast('تم حذف جميع البيانات', 'success');
                }
            });

            document.querySelectorAll('.priority-filter').forEach(checkbox => {
                checkbox.addEventListener('change', applyFilters);
            });

            starredTasksFilter.addEventListener('change', applyFilters);

            renderProjects();
            renderStatuses();
            renderProjectFilters();
            updateStatistics();
            applyFilters();
        });

        const recognitions = {};

        function toggleSpeechRecognition(button) {
            const textarea = button.parentNode.querySelector('textarea') || button.parentNode.querySelector('input');
            const icon = button.querySelector('i');
            const textareaId = textarea.id;

            if (!recognitions[textareaId]) {
                recognitions[textareaId] = new webkitSpeechRecognition();
                recognitions[textareaId].continuous = true;
                recognitions[textareaId].interimResults = true;
                recognitions[textareaId].lang = 'ar-SA';

                recognitions[textareaId].onresult = function(event) {
                    let finalTranscript = '';
                    for (let i = event.resultIndex; i < event.results.length; ++i) {
                        if (event.results[i].isFinal) {
                            finalTranscript += event.results[i][0].transcript + ' ';
                        }
                    }
                    textarea.value += finalTranscript;
                    textarea.scrollTop = textarea.scrollHeight;
                };

                recognitions[textareaId].onend = function() {
                    icon.textContent = 'mic';
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-outline-secondary');
                    showToast('تم إيقاف التسجيل الصوتي', 'info');
                    
                    // إضافة شيك بوكس للمهام المميزة
                    const starredTasksContainer = document.getElementById('starred-tasks-container');
                    const starredTasksList = starredTasksContainer.querySelector('tbody');
                    const starredTasks = starredTasksList.querySelectorAll('tr');
                    
                    starredTasks.forEach(task => {
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.className = 'form-check-input starred-task-checkbox';
                        checkbox.addEventListener('change', function() {
                            const projectId = this.closest('tr').dataset.projectId;
                            const taskId = this.closest('tr').dataset.taskId;
                            const task = projects[projectId].tasks[taskId];
                            task.status = this.checked ? 'مكتملة' : 'قيد الانتظار';
                            saveProjects();
                            renderProjects();
                            applyFilters();
                            showToast(this.checked ? 'تم تحويل المهمة إلى مكتملة' : 'تم تحويل المهمة إلى قيد الانتظار', 'success');
                        });
                        task.querySelector('td:first-child').prepend(checkbox);
                    });
                };
            }

            if (icon.textContent === 'mic') {
                recognitions[textareaId].start();
                icon.textContent = 'mic_off';
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-danger');
                showToast('تم بدء التسجيل الصوتي', 'success');
            } else {
                recognitions[textareaId].stop();
                icon.textContent = 'mic';
                button.classList.remove('btn-danger');
                button.classList.add('btn-outline-secondary');
            }
        }
    </script>
</body>
</html>