<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Manage Notes</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <style>
        .card {
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body style="background-color: rgb(217, 213, 213);">
    <?php include '../_partials/_navBar.php'; ?>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Welcome to Your Note Management Dashboard</h2>

        <div class="row">
            <!-- Create Folder Card -->
            <div class="col-md-3 mb-3">
                <div class="card p-3 text-center" data-bs-toggle="modal" data-bs-target="#createFolderModal">
                    <h5>Create Folder</h5>
                    <p class="text-muted">Organize notes with folders.</p>
                </div>
            </div>

            <!-- Search Folder Card -->
            <div class="col-md-3 mb-3">
                <div class="card p-3 text-center" data-bs-toggle="modal" data-bs-target="#searchFolderModal">
                    <h5>Search Folder</h5>
                    <p class="text-muted">Find folders by name.</p>
                </div>
            </div>

            <!-- Upload File Card -->
            <div class="col-md-3 mb-3">
                <div class="card p-3 text-center" data-bs-toggle="modal" data-bs-target="#uploadFileModal">
                    <h5>Upload File</h5>
                    <p class="text-muted">Add files to your folders.</p>
                </div>
            </div>

            <!-- View Folders Card -->
            <div class="col-md-3 mb-3">
                <div class="card p-3 text-center" data-bs-toggle="modal" data-bs-target="#viewFoldersModal">
                    <h5>View Folders</h5>
                    <p class="text-muted">Browse all your folders and files.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Folder Modal -->
    <div class="modal fade" id="createFolderModal" tabindex="-1" aria-labelledby="createFolderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createFolderModalLabel">Create New Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="folderForm">
                        <input type="text" id="folderName" class="form-control mb-3" placeholder="Enter folder name" required>
                        <button type="submit" class="btn btn-primary w-100">Create Folder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Folder Modal -->
    <div class="modal fade" id="searchFolderModal" tabindex="-1" aria-labelledby="searchFolderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchFolderModalLabel">Search Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchFolder" class="form-control mb-3" placeholder="Search folder by name">
                    <div id="folderSearchResult" class="mt-2">
                        <p class="text-muted text-center">Results will appear here...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload File Modal -->
    <div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFileModalLabel">Upload File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" enctype="multipart/form-data">
                        <label for="folderSelect" class="form-label">Select Folder:</label>
                        <select id="folderSelect" class="form-control mb-3" required>
                            <option value="" disabled selected>Select a folder</option>
                        </select>
                        <label for="fileUpload" class="form-label">Select File:</label>
                        <input type="file" id="fileUpload" class="form-control mb-3" required>
                        <button type="submit" class="btn btn-primary w-100">Upload File</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Folders Modal -->
    <div class="modal fade" id="viewFoldersModal" tabindex="-1" aria-labelledby="viewFoldersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewFoldersModalLabel">View Folders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="viewFolderList" class="list-group">
                        <p class="text-muted text-center">Loading folders...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showAlert(message, type = 'info') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} mt-2`;
            alertDiv.textContent = message;
            document.body.prepend(alertDiv);
            setTimeout(() => alertDiv.remove(), 3000);
        }

        // Create Folder
        document.getElementById('folderForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const folderName = document.getElementById('folderName').value;
            const formData = new FormData();
            formData.append('createFolder', true);
            formData.append('folderName', folderName);

            fetch('../controllers/folder_controller.php', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    showAlert(data.message, 'success');
                    document.getElementById('folderName').value = '';
                    document.querySelector('#createFolderModal .btn-close').click();
                })
                .catch(error => showAlert('Error creating folder', 'danger'));
        });

        // Search Folder
        document.getElementById('searchFolder').addEventListener('input', function (event) {
            const query = event.target.value;
            fetch(`../controllers/folder_controller.php?searchFolder=${query}`)
                .then(response => response.json())
                .then(data => {
                    const folderSearchResult = document.getElementById('folderSearchResult');
                    folderSearchResult.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(folder => {
                            const folderItem = document.createElement('div');
                            folderItem.className = 'folder-item list-group-item';
                            folderItem.textContent = folder.name;
                            folderSearchResult.appendChild(folderItem);
                        });
                    } else {
                        folderSearchResult.innerHTML = '<p class="text-muted text-center">No folders found.</p>';
                    }
                })
                .catch(error => showAlert('Error searching folders', 'danger'));
        });

        // Populate Folder Select
        function populateFolderSelect() {
            fetch('../controllers/folder_controller.php')
                .then(response => response.json())
                .then(data => {
                    const folderSelect = document.getElementById('folderSelect');
                    folderSelect.innerHTML = '<option value="" disabled selected>Select a folder</option>';
                    data.forEach(folder => {
                        const option = document.createElement('option');
                        option.value = folder.id;
                        option.textContent = folder.name;
                        folderSelect.appendChild(option);
                    });
                })
                .catch(error => showAlert('Error loading folders', 'danger'));
        }

        // View Folders
        function loadFolderList() {
            fetch('../controllers/folder_controller.php')
                .then(response => response.json())
                .then(data => {
                    const viewFolderList = document.getElementById('viewFolderList');
                    viewFolderList.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(folder => {
                            const folderItem = document.createElement('button');
                            folderItem.className = 'list-group-item list-group-item-action';
                            folderItem.textContent = folder.name;
                            folderItem.onclick = () => showAlert(`Folder ID: ${folder.id}`, 'info');
                            viewFolderList.appendChild(folderItem);
                        });
                    } else {
                        viewFolderList.innerHTML = '<p class="text-muted text-center">No folders found.</p>';
                    }
                })
                .catch(error => showAlert('Error loading folders', 'danger'));
        }

        // Initial setup
        populateFolderSelect();
        document.querySelector('#viewFoldersModal').addEventListener('show.bs.modal', loadFolderList);
    </script>
</body>
</html>
