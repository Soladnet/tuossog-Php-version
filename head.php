<link rel="stylesheet" media="screen" href="css/style.css">
<link rel="stylesheet" href="css/hint.min.css">
<link rel="shortcut icon" href="favicon.ico">

<script src="scripts/svgeezy.js"></script>
<script>
//    $(function() {
//        svgeezy.init(false, "png");
//    });
    $(function() {
        $("#show-suggested-friends,#show-suggested-community,#gossbag-text,#messages-text,#gossbag-close,#messages-close,#user-actions,#user-more-option,#show-full-profile,#search,#search-close").click(function() {
            showOption(this);
        });
        $.ajaxSetup({
            url: 'tuossog-api-json.php',
            dataType: "json",
            type: "post",
            error: function(jqXHR, textStatus, errorThrown) {
                manageError(jqXHR, textStatus, errorThrown,{uid:readCookie("user_auth")});
            }
        });
//        sendData("loadGossbag", {uid: readCookie("user_auth")});
    });
</script>
<script type="text/javascript" src="scripts/script.js?v=1.1"></script>
<!-- <link href='http://fonts.googleapis.com/css?family=Ubuntu|Open+Sans:300' rel='stylesheet' type='text/css'> -->
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" > 
