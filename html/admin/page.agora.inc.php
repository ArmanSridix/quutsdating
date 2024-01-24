<?php

    /*!
     * https://raccoonsquare.com
     * raccoonsquare@gmail.com
     *
     * Copyright 2012-2023 Demyanchuk Dmitry (raccoonsquare@gmail.com)
     */

    if (!admin::isSession()) {

        header("Location: /admin/login");
        exit;
    }

    // Administrator info

    $admin = new admin($dbo);
    $admin->setId(admin::getCurrentAdminId());

    $admin_info = $admin->get();

    //

    $error = false;
    $error_message = '';

    $stats = new stats($dbo);
    $settings = new settings($dbo);

    $agora_app_enabled = 1;
    $agora_app_id = "";
    $agora_app_certificate = "";

    if (!empty($_POST)) {

        $authToken = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';

        $agora_app_enabled = isset($_POST['agora_app_enabled']) ? $_POST['agora_app_enabled'] : 1;
        $agora_app_id = isset($_POST['agora_app_id']) ? $_POST['agora_app_id'] : '';
        $agora_app_certificate = isset($_POST['agora_app_certificate']) ? $_POST['agora_app_certificate'] : '';

        if ($authToken === helper::getAuthenticityToken() && $admin_info['access_level'] < ADMIN_ACCESS_LEVEL_MODERATOR_RIGHTS) {

            $agora_app_enabled = helper::clearInt($agora_app_enabled);
            $agora_app_id = helper::clearText($agora_app_id);
            $agora_app_certificate = helper::clearText($agora_app_certificate);

            $settings->setValue("agora_app_enabled", $agora_app_enabled);
            $settings->setValue("agora_app_id", 0, $agora_app_id);
            $settings->setValue("agora_app_certificate", 0, $agora_app_certificate);
        }
    }

    $config = $settings->get();

    $arr = array();

    $arr = $config['agora_app_enabled'];
    $agora_app_enabled = $arr['intValue'];

    $arr = $config['agora_app_id'];
    $agora_app_id = $arr['textValue'];

    $arr = $config['agora_app_certificate'];
    $agora_app_certificate = $arr['textValue'];

    //

    if ($admin_info['access_level'] > ADMIN_ACCESS_LEVEL_READ_WRITE_RIGHTS) {
    
        if (strlen($agora_app_id) > 4) {

            $agora_app_id = "*****".substr($agora_app_id, -4);
        }
    
        if (strlen($agora_app_certificate) > 4) {

            $agora_app_certificate = "*****".substr($agora_app_certificate, -4);
        }
    }

    //

    $page_id = "agora";

    $error = false;
    $error_message = '';

    helper::newAuthenticityToken();

    $css_files = array("mytheme.css");
    $page_title = "Agora Settings | Admin Panel";

    include_once("html/common/admin_header.inc.php");
?>

<body class="fix-header fix-sidebar card-no-border">

    <div id="main-wrapper">

        <?php

            include_once("html/common/admin_topbar.inc.php");
        ?>

        <?php

            include_once("html/common/admin_sidebar.inc.php");
        ?>

        <div class="page-wrapper">

            <div class="container-fluid">

                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin/main">Home</a></li>
                            <li class="breadcrumb-item active">Agora Settings</li>
                        </ol>
                    </div>
                </div>

                <?php

                    if (!$admin_info['error'] && $admin_info['access_level'] > ADMIN_ACCESS_LEVEL_READ_WRITE_RIGHTS) {

                        ?>
                        <div class="card">
                            <div class="card-body collapse show">
                                <h4 class="card-title">Warning!</h4>
                                <p class="card-text">Your account does not have rights to make changes in this section! The changes you've made will not be saved.</p>
                            </div>
                        </div>
                        <?php
                    }
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="card-title">Warning!</h4>
                                <p class="card-text">In application changes will take effect during the next user authorization.</p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Agora App Settings</h4>
                                <h6 class="card-subtitle d-none">How to get agora app_id and app_certificate: <a href="https://raccoonsquare.com/help/how_to_get_agora_app_id_and_app_certificate/" target="_blank">https://raccoonsquare.com/help/how_to_get_agora_app_id_and_app_certificate/</a></h6>

                                <form action="/admin/agora" method="post">

                                    <input type="hidden" name="authenticity_token" value="<?php echo helper::getAuthenticityToken(); ?>">

                                    <div class="form-group">
                                        <label>Agora Enabled</label>
                                        <select class="form-control" name="agora_app_enabled">
                                            <option <?php if ($agora_app_enabled == 0) echo 'selected="selected"'; ?> value="0">Off (Disabled)</option>
                                            <option <?php if ($agora_app_enabled == 1) echo 'selected="selected"'; ?> value="1">On (Enabled)</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="agora_app_id" class="active">Agora App ID</label>
                                        <input class="form-control" id="agora_app_id" type="text" size="255" name="agora_app_id" value="<?php echo $agora_app_id; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="agora_app_certificate" class="active">Agora App Certificate</label>
                                        <input class="form-control" id="agora_app_certificate" type="text" size="255" name="agora_app_certificate" value="<?php echo $agora_app_certificate; ?>">
                                    </div>

                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <button class="btn btn-info text-uppercase waves-effect waves-light" type="submit">Save</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div> <!-- End Container fluid  -->

            <?php

                include_once("html/common/admin_footer.inc.php");
            ?>

        </div> <!-- End Page wrapper  -->
    </div> <!-- End Wrapper -->

</body>

</html>
