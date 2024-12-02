<?php
declare(strict_types=1);

function table_view() {
    require_once 'dbh.inc.php';
    require_once 'admin_model.inc.php';

    try {
        // Retrieve all table names
        $tables = get_all_tables($pdo);
    
        if (empty($tables)) {
            echo '<p class="w3-text-red">No tables found in the database.</p>';
        } else {
            foreach ($tables as $table) {
                echo '<div class="w3-card-4 w3-white w3-margin-bottom w3-round">';
                echo '<h2 class="w3-center w3-padding-16">Table: ' . $table . '</h2>';

                // Retrieve data for the current table
                $columns = get_table_columns($pdo, $table);
                $data = get_table_data($pdo, $table);
                print_r($columns);
            
                // Start HTML table
                echo '<table class="w3-table-all w3-bordered w3-hoverable w3-centered" style="width: 100%;">';
            
                // Table Headers
                echo '<tr>';
                foreach ($columns as $columnName) {
                    echo '<th>' . $columnName . '</th>';
                }
                echo '<th>Actions</th>';
                echo '</tr>';
                
                // Form for creating a new row
                echo '<tr>';
                echo '<form action="includes/admin.inc.php" method="post">';
                echo '<input type="hidden" name="table" value="' . $table . '">';
                foreach ($columns as $columnName) {
                    echo '<td><input type="text" name="' . $columnName . '" class="w3-input w3-border"></td>';
                }
                echo '<td><button type="submit" name="create-row" class="w3-button w3-blue w3-hover-light-blue">Create Row</button></td>';
                echo '</form>';
                echo '</tr>';

                // Table Rows with form and input field to update each record
                foreach ($data as $row) {
                    echo '<tr>';
                    echo '<form action="includes/admin.inc.php" method="post">';
                    echo '<input type="hidden" name="first_id" value="' . $row['id'] . '">';
                    echo '<input type="hidden" name="table" value="' . $table . '">';
                    foreach ($row as $column => $value) {
                        echo '<td><input type="text" name="' . $column . '" value="' . $value . '" class="w3-hinput w3-border"></td>';
                    }
                    echo '<td><button type="submit" name="update-row" class="w3-button w3-yellow w3-hover-light-yellow">Update Row</button>';
                    echo '</form>';

                    // Delete Row Button
                    echo '<form action="includes/admin.inc.php" method="post">';
                    echo '<input type="hidden" name="first_id" value="' . $row['id'] . '">';
                    echo '<input type="hidden" name="table" value="' . $table . '">';
                    echo '<button type="submit" name="delete-row" class="w3-button w3-red w3-hover-light-red">Delete Row</button></td>';
                    echo '</form>';
                    echo '</tr>';
                }

                // End HTML table
                echo '</table>';
                echo '</div>';
            }
        }
    } catch (Exception $e) {
        // Display error message gracefully
        echo '<p class="w3-text-red">Error: ' . $e->getMessage() . '</p>';
    }
}