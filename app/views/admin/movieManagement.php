<html>

<head>
  <title>Zenith</title>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css" />
</head>

<body>
<header>
    <a href="javascript:history.back();">
        <div class="back">
            <span></span>
            <span></span>
        </div>
    </a>
    
    <h2>Movie Management</h2>

    <div class="right-nav">
        <a href="#">
            <span class="username">
                <?php echo $username ?>
             </span>
        </a>
        <a href="<?= BASE_URL ?>/auth/register"><button class="btn logout">Logout</button></a>
    </div>
     
</header>
  
<main>
    <div class="admin-container">
        <div class="movie-admin-action">
            <div class="filter-section">
                <button class="filter-btn">Filter</button>
                <input type="search" placeholder="Search" class="search-input">
            </div>
            <a href="<?= BASE_URL ?>/admin/addMovie"><button class="add-movie-btn">Add Movie</button></a>
        </div>
            <div class="movie-table-header">
                    <div>ID</div>
                    <div>Movie Name</div>
                    <div>Year</div>
                    <div>Type</div>
                    <div>Genres</div>
                    <div>Votes</div>
                    <div>Action</div>
            </div>

            <div class="movie-data">
                <div class="movie-table-data">
                        <div>
                            <label class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                <span>1</span>
                            </label>
                        </div>
                        <div>Ponyo</div>
                        <div>2008</div>
                        <div>Movie</div>
                        <div>
                            <p>Horror</p>
                            <p>Adventure</p>
                        </div>
                        <div>1880</div>
                        <div>
                            <button class="update-btn">Update</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                </div>
                <div class="movie-table-data">
                        <div>
                            <label class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                <span>1</span>
                            </label>
                        </div>
                        <div>Ponyo</div>
                        <div>2008</div>
                        <div>Movie</div>
                        <div>
                            <p>Horror</p>
                            <p>Adventure</p>
                        </div>
                        <div>1880</div>
                        <div>
                            <button class="update-btn">Update</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                </div>
                <div class="movie-table-data">
                        <div>
                            <label class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                <span>1</span>
                            </label>
                        </div>
                        <div>Ponyo</div>
                        <div>2008</div>
                        <div>Movie</div>
                        <div>
                            <p>Horror</p>
                            <p>Adventure</p>
                        </div>
                        <div>1880</div>
                        <div>
                            <button class="update-btn">Update</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                </div>
                <div class="movie-table-data">
                        <div>
                            <label class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                <span>1</span>
                            </label>
                        </div>
                        <div>Ponyo</div>
                        <div>2008</div>
                        <div>Movie</div>
                        <div>
                            <p>Horror</p>
                            <p>Adventure</p>
                        </div>
                        <div>1880</div>
                        <div>
                            <button class="update-btn">Update</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                        
                </div>
                <div class="movie-table-data">
                        <div>
                            <label class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                <span>1</span>
                            </label>
                        </div>
                        <div>Ponyo</div>
                        <div>2008</div>
                        <div>Movie</div>
                        <div>
                            <p>Horror</p>
                            <p>Adventure</p>
                        </div>
                        <div>1880</div>
                        <div>
                            <button class="update-btn">Update</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                </div>
                <div class="movie-table-data">
                        <div>
                            <label class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                <span>1</span>
                            </label>
                        </div>
                        <div>Ponyo</div>
                        <div>2008</div>
                        <div>Movie</div>
                        <div>
                            <p>Horror</p>
                            <p>Adventure</p>
                        </div>
                        <div>1880</div>
                        <div>
                            <button class="update-btn">Update</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                        
                </div>
            </div>
    </div>
</main>
<script src="<?= BASE_URL ?>/js/main.js"></script>
</body>
</html>