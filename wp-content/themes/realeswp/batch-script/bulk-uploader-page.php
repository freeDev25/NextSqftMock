<?php

add_action('admin_menu', 'addSeoMenu', 9);

function addSeoMenu()
{
    //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    add_menu_page("Bulk Seo Page", 'Bulk Seo Page', 'administrator', 'batch_seo_page',  'displaySeoDashboard', 'dashicons-chart-area', 26);

    //add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
    // add_submenu_page( $this->plugin_name, 'Plugin Name Settings', 'Settings', 'administrator', $this->plugin_name.'-settings', array( $this, 'displaySeoSettings' ));
}

function notice($message, $type = "success")
{
    $class = 'notice notice-' . $type;
    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
}


function displaySeoDashboard()
{

    // readExcel(null);

    $success = 1;

    $dest = wp_upload_dir();

    if (isset($_POST['upload_bulk']) && $_POST['upload_bulk']) {

        $file_tmp = $_FILES['upload_bulk_file']['tmp_name'];
        $file_name  = $_FILES['upload_bulk_file']['name'];

        if (!is_dir($dest['basedir'] . "/seo-excel")) {
            mkdir($dest['basedir'] . "/seo-excel");
        }

        $file_names = explode('.', $file_name);
        $file_name = $file_names[0] . "." . $file_names[1];

        $file = $dest['basedir'] . "/seo-excel/" . $file_name;
        if (move_uploaded_file($file_tmp, $file)) {
            readExcel($file);
            $success = 2;
        } else {
            $success = 3;
        }
    }

?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Bulk Seo page</h1>
        <?php
        if ($success === 2) {
            notice(__("Pages updated successfully with seo content.", 'batch-seo-sctipt'), 'success');
        } else if ($success === 2) {
            notice(__("Some error occured.", 'batch-seo-sctipt'), 'error');
        }
        ?>
        <form class="upload-fporm posts-filter" name="file_upload" id="file_upload" action="" method="post" enctype="multipart/form-data">
            <label for="upload-bulk" aria-label="upload-bulk">
                Upload Excel
                <!-- <span class="dashicons dashicons-cloud-saved"></span> <a href=""></a> -->
            </label>
            <input type="file" name="upload_bulk_file" required id="upload-bulk" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
            <input type="hidden" name="upload_bulk" value="1" id="upload-bulk" />
            <div class="upload actions">
                <button type="submit" class=" components-button editor-post-publish-panel__toggle editor-post-publish-button__button is-primary">Upload</button>
            </div>
        </form>
    </div>
<?php
}
?>