<?php
include "../library_insol/all_include.php";
include "../global_functions.php";

        global $dCON;
        $event_id = intval($_REQUEST['eventid']);
        $SQL = "";
        $SQL = "SELECT * FROM  tbl_event WHERE event_id = ?";
        $events = $dCON->prepare($SQL);
        $events->bindParam(1, $event_id);
        $events->execute();
        $rs_events = $events->fetchAll();
        $events->closeCursor();
        $countEVENT = count($rs_events);

        $event_name = stripslashes($rs_events[0]['event_name']);
        $event_title = stripslashes($rs_events[0]['event_short_description']);

        $event_data = $event_name . ": " . $event_title;
    ?>


<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $event_data; ?></title>
    <script type="text/javascript" src="/include/scripts/prototype.js"></script>
    <!--[if lt IE 7.]>
<script defer type="text/javascript" src="/include/scripts/pngfix.js"></script>
<![endif]-->
    <script type="text/javascript" src="<?php echo SITE_ROOT; ?>ereg/include/scripts.js"></script>
    <link rel="P3Pv1" href="/w3c/p3p.xml" />

    <link type="text/css" rel="stylesheet" href="/themes/global/fonts.css" />
    <style>
    a.skipaccessible {
        left: -999px;
        position: absolute;
        top: auto;
        width: 1px;
        height: 1px;
        overflow: hidden;
        z-index: -999;
    }

    a.skipaccessible:focus,
    a.skipaccessible:active {
        color: #fff;
        background-color: #2c506c;
        left: 0px;
        top: auto;
        width: auto;
        height: auto;
        overflow: auto;
        /*margin: 10px 35%;*/
        padding: 5px;
        border-radius: 15px;
        border: 2px solid #fff;
        text-align: center;
        font-size: 1.2em;
        z-index: 999;
    }
    </style>
    <link type="text/css" rel="stylesheet" href="/themes/global/custom_fonts/fonts.css" />
    <link type="text/css" rel="stylesheet"
        href="<?php echo SITE_ROOT; ?>ereg/include/datepicker/css/jquery.dateselect.css" />
    <script type="text/javascript" src="https://staticcdn.eventscloud.com/libs/js/jquery/3.4.1/jquery-3.4.1.min.js">
    </script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.1.min.js"></script>
    <script>
    $.noConflict();
    </script>
    <style type="text/css">
    html {
        background: rgb(168, 183, 198);
    }

    body {
        margin: 0px;
    }

    td,
    div,
    font,
    p {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    td {
        color: black;
    }

    label {
        padding: 2px;
        display: inline-block;
    }

    .standard label {
        padding: 2px;
        display: inline;
    }

    .displayInlineBlock {
        display: inline-block;
    }

    .displayInline {
        display: inline;
    }

    .displayInline {
        display: inline;
    }

    .sr-only {
        position: absolute !important;
        height: 1px;
        width: 1px;
        overflow: hidden;
        padding: 0 !important;
        border: 0 ! important;
        white-space: nowrap !important;
        clip: rect(1px 1px 1px 1px) !important;
        /* IE6, IE7 */
        clip: rect(1px, 1px, 1px, 1px) !important;
        clip-path: inset(50%) !important;
    }

    select,
    input,
    textarea {
        font-family: Arial, sans-serif;
        font-size: 12px;
        border: 1px solid #abadb3;
        border-right-color: #dbdfe6;
        border-bottom-color: #dbdfe6;
    }

    input.button {
        border: 0;
    }

    .standard {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    .header {
        font-family: Arial;
        font-size: 13;
        color: #000000;
        font-weight: bold;
    }

    .on {
        font-family: Arial, sans-serif;
        color: #FFFFFF;
        font-size: 14;
        font-weight: bold;
    }

    .off {
        font-family: Arial, sans-serif;
        color: #000006;
        font-size: 12;
    }

    .red {
        font-family: Arial, sans-serif;
        font-size: 12px;
        color: #C70000 !important;
    }

    .red.r-message b {
        color: #C70000 !important;
    }

    .redLabel,
    .redLabel.questionLabel,
    a.redLabel:link,
    a.redLabel:visited {
        font-family: Arial, sans-serif;
        font-size: 12px;
        color: #C70000 !important;
    }

    .error {
        background: #ffeeee;
        border: 1px solid #ff9999;
    }

    .selectbox {
        color: #000;
        font-family: arial;
        font-size: 8pt;
        background-color: #FFF;
    }

    .headercell {
        font-family: arial;
        font-size: 8pt;
        font-weight: bold;
        color: #000000;
    }

    .maincell {
        font-family: arial;
        font-size: 8pt;
        color: #000;
        background: #FFF;
        text-align: center;
        height: 22px;
    }

    .maincellover {
        font-family: arial;
        font-size: 8pt;
        font-weight: bold;
        color: #FFF;
        background: #000066;
        text-align: center;
        cursor: pointer;
    }

    .tablerow1 {
        background: #ffffff;
    }

    .tablerow2 {
        background: #eeeeee;
    }

    a:link,
    a:visited {
        text-decoration: none;
        color: rgb(0, 0, 238);
    }

    a:active,
    a:focus,
    a.menu:not(:hover) {
        color: darken(@link-color, 15%);
        outline: 5px auto Highlight !important;
        outline: 5px auto -webkit-focus-ring-color !important;
    }

    select:active,
    select:focus,
    textarea:active,
    textarea:focus,
    input:active,
    input:focus {
        color: darken(@link-color, 15%);
        outline: 5px auto Highlight !important;
        outline: 5px auto -webkit-focus-ring-color !important;
    }

    a.menu:link,
    a.menu:visited {
        font-family: Arial, sans-serif;
        font-size: 13;
        text-decoration: none;
        color: #FFFFFF;
    }

    a.menu_standard:link,
    a.menu_standard:visited {
        font-family: Arial, sans-serif;
        font-size: 12;
        text-decoration: none;
        color: #FFFFFF;
    }

    a.menu:hover {
        color: #FFFFFF;
    }

    a.footer:link,
    a.footer:visited {
        font-family: Arial, sans-serif;
        font-size: 12px;
        text-decoration: underline;
        color: #FFFFFF;
    }

    a.footer:hover {
        text-decoration: none;
        color: #FFFFFF;
    }

    .poweredBy {
        margin: 0;
        padding: 16px 0 0 10px;
    }

    div.thumbContainer {
        display: table-cell;
        vertical-align: middle;
        width: 100px;
        height: 100px;
    }

    .questionInput input[readonly='readonly'],
    .questionInput select[readonly='readonly'] {
        background-color: #cccccc;
    }

    div.thumbContainer>img {
        border: none;
        max-width: 100px;
        max-height: 100px;
        image-rendering: -moz-crisp-edges;
        image-rendering: -o-crisp-edges;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
        -ms-interpolation-mode: nearest-neighbor;
    }

    .success {
        color: green;
    }

    .fail {
        color: red;
    }

    .disabled {
        position: relative;
    }

    .disabled::before {
        content: ' ';
        position: absolute;
        display: block;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 9999;
    }

    #additional-travel-table th,
    #additional-travel-table td {
        padding: 5px;
    }

    #additional-travel-table td.airport {
        text-align: center;
    }

    .paynowbutton {
        background: rebeccapurple;
        border-color: #abadb3 #dbdfe6 #dbdfe6 #abadb3;
        color: #ffffff;
        cursor: pointer;
        font-family: arial, helvetica, sans-serif;
        font-size: 13px;
        font-weight: bold;
        height: 24px;
        margin: 0 5px;
        padding: 0 0 4px;
        width: 130px;
    }

    @media print {
        .no-print {
            display: none
        }
    }

    .margin-right10 {
        margin-right: 10px !important;
        cursor: pointer !important;
    }

    td.questiondescription {
        width: auto !important;
    }

    #buttontable .button.r-button {
        display: inline-block !important;
    }

    #registerbuttons .button.r-button {
        display: inline-block !important;
    }

    .time-input {
        min-width: 50px;
    }
    </style>
    <script language="javascript">
    window.isRTL = false;
    </script>
    <style>
    #live-less-editor-relatedvars-button {
        font-size: 12px;
    }

    .less-error-message {
        display: none !important;
    }

    td.branding-hdr h1 {
        margin-block-start: 0em;
        margin-block-end: 0em;
    }

    div.autosuggest {
        position: absolute;
        margin-top: 5px;
        background: #ffffff;
        border: 1px solid #2c506c;
    }

    div.autosuggest ul {
        list-style: none;
        margin: 0px;
        padding: 5px;
        overflow: hidden;
    }

    div.autosuggest ul li a {
        display: block;
        padding: 1px;
        width: 100%;
    }

    div.autosuggest ul li a:hover {
        background-color: #444;
    }

    div.autosuggest ul li.as_highlight a:hover {
        color: #FFFFFF;
        background: #2c506c;
    }

    div.autosuggest ul li.as_highlight a {
        color: #FFFFFF;
        background: #2c506c;
    }

    tr.left_padding td {
        padding-left: 15px;
    }

    .hidden_label {
        position: absolute !important;
        clip: rect(1px 1px 1px 1px);
        /* IE6, IE7 */
        clip: rect(1px, 1px, 1px, 1px);
    }

    .r-button,
    .r-multicheckbox hr,
    .r-mobile {
        display: none;
    }

    h1[role="banner"] {
        margin: 0px
    }
    </style>
    <meta property="og:title" content="<?php echo $event_data; ?>" class="notranslate" />
    <meta property="og:image" content="<?php echo SITE_ROOT; ?>ereg/file_uploads/webinaroption2thinlogo.jpg"
        class="notranslate" />
    <link type="text/css" rel="stylesheet" href="<?php echo SITE_ROOT; ?>ereg/include/pickadate/themes/default.css" />
    <link type="text/css" rel="stylesheet"
        href="<?php echo SITE_ROOT; ?>ereg/include/pickadate/themes/default.date.css" />
    <link type="text/css" rel="stylesheet"
        href="<?php echo SITE_ROOT; ?>ereg/include/pickadate/themes/default.time.css" />
    <link rel="stylesheet" href="/include/fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
    <style>
    /* set spinner color to menu background color */
    .spinner {
        border-left: 6px solid rgba(44, 80, 108, .15) !important;
        border-right: 6px solid rgba(44, 80, 108, .15) !important;
        border-bottom: 6px solid rgba(44, 80, 108, .15) !important;
        border-top: 6px solid rgba(44, 80, 108, .8) !important;
    }

    /* set the responsive buttons to match the desktop link color */
    input.button.r-button {
        color: rgb(0, 0, 238) !important;
        border: 2px solid rgb(0, 0, 238) !important;
    }

    /* set responsive menu border to match desktop menu font color */
    #r-breadcrumbs ul li,
    #r-breadcrumbs ul li a {
        color: #FFFFFF !important;
    }

    #r-breadcrumbs ul li.visible {
        display: list-item
    }

    /* set the responsive menu icon to match the desktp menu font color */
    span.r-count .r-crumb-trigger.fa-bars {
        color: #FFFFFF !important;
    }

    /* subnav */
    ul.r-mobile.pagebreaks li {
        background: #2c506c !important;
    }

    ul.r-mobile.pagebreaks li,
    ul.r-mobile.pagebreaks li:hover {
        color: transparent !important;
    }

    ul.r-mobile.pagebreaks li.selected {
        color: #000;
    }
    </style>
    <style>
    /*! Generated by Live LESS Theme Customizer */
    a.clear-selection-label:before {
        content: "f0e2";
        font-family: FontAwesome;
        margin-right: .5em
    }

    .r-remove-btn:before {
        content: "f014";
        font-family: FontAwesome;
        margin-right: .5em
    }

    .r-cancel-btn:before {
        content: "f00d";
        font-family: FontAwesome;
        margin-right: .5em
    }

    .r-upload-btn:before {
        content: "f093";
        font-family: FontAwesome;
        margin-right: .5em
    }

    .r-more-info-btn:before,
    a.more-info-btn:before {
        content: "f05a";
        font-family: FontAwesome;
        margin-right: .5em
    }

    .r-edit-btn:before {
        content: "f040";
        font-family: FontAwesome;
        margin-right: .5em
    }

    body.matchmaking table#ranking tbody tr:first-child>td:last-child::after,
    body.matchmaking table#ranking tbody tr:first-child>td:nth-child(2)::before {
        content: '25BC';
        display: inline-block;
        margin: 0 5px !important;
        opacity: .75
    }

    div,
    font,
    p,
    td {
        font-size: 12px
    }

    td {
        color: #000
    }

    label {
        padding: 2px;
        display: inline-block
    }

    .standard label {
        padding: 2px;
        display: inline
    }

    .displayInlineBlock {
        display: inline-block
    }

    input,
    select,
    textarea {
        font-size: 12px;
        border: 1px solid #abadb3;
        border-right-color: #dbdfe6;
        border-bottom-color: #dbdfe6
    }

    input.button {
        border: 0
    }

    .standard {
        font-size: 12px
    }

    .header {
        font-size: 12px;
        color: #000;
        font-weight: 700
    }

    .on {
        color: transparent;
        font-size: 12px;
        font-weight: 700
    }

    .off {
        color: #1c2544;
        font-size: 12px
    }

    .red {
        font-size: 12px;
        color: #C70000
    }

    .redLabel,
    a.redLabel:link,
    a.redLabel:visited {
        font-size: 12px;
        color: #C70000 !important
    }

    .error {
        background: #fee
    }

    .selectbox {
        color: #000;
        font-size: 8pt;
        background-color: #FFF
    }

    .headercell {
        font-size: 8pt;
        font-weight: 700;
        color: #000
    }

    .maincell {
        font-size: 8pt;
        color: #000;
        background: #FFF;
        text-align: center;
        height: 22px
    }

    .maincellover {
        font-size: 8pt;
        font-weight: 700;
        color: #FFF;
        background: #006;
        text-align: center;
        cursor: pointer
    }

    .drop_left,
    .drop_right {
        width: 7px;
        background: 0 0
    }

    .drop_b {
        height: 7px;
        background: 0 0
    }

    .tablerow1 {
        background: #fff
    }

    .tablerow2 {
        background: #eee
    }

    a:link,
    a:visited {
        text-decoration: none;
        color: #00e;
        outline: 0
    }

    a:hover {
        color: #0000a2
    }

    a.menu:link,
    a.menu:visited,
    a.menu_standard:link,
    a.menu_standard:visited {
        font-size: 12px;
        text-decoration: none;
        color: #000
    }

    a.menu:hover {
        color: #000
    }

    a.footer:link,
    a.footer:visited {
        font-size: 12px;
        text-decoration: underline;
        color: #000
    }

    a.footer:hover {
        text-decoration: none;
        color: #000
    }

    .poweredBy {
        margin: 0;
        padding: 16px 0 0 10px
    }

    div.thumbContainer {
        display: table-cell;
        vertical-align: middle;
        width: 100px;
        height: 100px
    }

    .questionInput input[readonly=readonly],
    .questionInput select[readonly=readonly] {
        background-color: #ccc
    }

    div.thumbContainer>img {
        border: none;
        max-width: 100px;
        max-height: 100px;
        image-rendering: -moz-crisp-edges;
        image-rendering: -o-crisp-edges;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
        -ms-interpolation-mode: nearest-neighbor
    }

    .success {
        color: green
    }

    .fail {
        color: red
    }

    #r-breadcrumbs {
        padding: .5em;
        position: relative
    }

    #r-breadcrumbs ul {
        list-style: none;
        text-align: center;
        height: 30px;
        width: 100%;
        max-width: 750px;
        display: table-row;
        margin: 0;
        padding: 0
    }

    #r-breadcrumbs ul li {
        height: 30px;
        transition: all .5s;
        display: table-cell;
        vertical-align: middle
    }

    #r-breadcrumbs ul li img {
        margin: 0 10px
    }

    span.r-count {
        display: block;
        position: absolute;
        right: 15px;
        top: 10px;
        color: #f0f0f0
    }

    span.r-count .r-crumb-trigger {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 4px;
        margin-left: 10px
    }

    td.branding-hdr {
        text-align: center
    }

    @media (min-width:801px) {

        .r-cancel-btn:before,
        .r-edit-btn:before,
        .r-more-info-btn:before,
        .r-remove-btn:before,
        .r-upload-btn:before,
        a.clear-selection-label:before,
        a.more-info-btn:before {
            content: "";
            margin-right: 0
        }

        body.matchmaking table#ranking tbody tr:first-child>td:last-child::after,
        body.matchmaking table#ranking tbody tr:first-child>td:nth-child(2)::before {
            content: '';
            margin-right: 0
        }
    }

    @media (max-width:800px) {
        * {
            box-sizing: border-box;
            font-size: 1em !important
        }

        body {
            color: #333
        }

        .redLabel,
        a.redLabel:link,
        a.redLabel:visited {
            color: #d95c5c
        }

        img {
            max-width: 100%;
            height: auto
        }

        #inner_content {
            padding: 7px !important
        }

        td.red.requiredlabel {
            display: block;
            padding: 10px 0 15px !important
        }

        div.logo-img-container {
            width: auto !important;
            height: auto !important;
            text-align: center
        }

        #orig-nav {
            display: none
        }

        #r-breadcrumbs ul li {
            display: none;
            padding: 8px 0 0
        }

        #r-breadcrumbs ul li:last-child {
            border-bottom: 2px solid #fff
        }

        #r-breadcrumbs ul li.on {
            display: table-cell;
            text-align: left
        }

        #r-breadcrumbs ul li.off,
        #r-breadcrumbs ul li.previous-step {
            display: none;
            width: 100% !important;
            text-align: left;
            height: 2em;
            border-bottom: 1px solid #f0f0f0;
            margin: 0 auto
        }

        #r-breadcrumbs ul li.off {
            opacity: .5
        }

        #r-breadcrumbs ul li.previous-step:nth-child(1) {
            margin-top: 1em
        }

        #r-breadcrumbs ul {
            display: block;
            height: auto;
            min-height: 30px
        }

        #r-breadcrumbs ul li img {
            display: none
        }

        #r-breadcrumbs ul li.visible {
            display: list-item
        }

        span.r-count {
            display: block;
            position: absolute;
            right: 10px;
            top: 16px;
            color: #f0f0f0
        }

        span.r-count img {
            position: relative;
            top: 10px
        }

        .r-desktop {
            display: none !important
        }

        .fa {
            font-family: FontAwesome !important
        }

        table tbody,
        table td:not([class^=picker]):not([class^=optionclassiso]),
        table th:not([class^=picker]),
        table thead,
        table tr,
        table:not(.picker__table) {
            display: block;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important
        }

        table.picker__table tbody,
        table.picker__table thead {
            display: table-row-group
        }

        table.picker__table tr {
            display: table-row
        }

        table.picker__table td {
            display: table-cell !important
        }

        table.r-table,
        table.r-table tbody,
        table.r-table td,
        table.r-table th,
        table.r-table thead,
        table.r-table tr {
            width: inherit !important;
            padding: inherit !important;
            margin: inherit !important;
            border: inherit !important
        }

        table.r-table {
            width: 100% !important
        }

        table.r-table td,
        table.r-table th {
            display: table-cell !important;
            padding: 5px !important;
            font-size: 13px !important
        }

        .reg-record-display td,
        .reg-record-display th {
            font-size: 13px !important
        }

        table.r-table tr {
            display: table-row !important
        }

        table.r-table td:first-child {
            width: 50% !important
        }

        td {
            text-align: left
        }

        td.branding-hdr {
            text-align: center
        }

        td.questionLabel {
            text-align: left
        }

        td input[type=checkbox],
        td input[type=radio] {
            float: right !important;
            width: 20px !important
        }

        input[type=image] {
            width: auto !important
        }

        td img[alt=arrow] {
            float: left
        }

        form {
            padding: 0 10px
        }

        td.red {
            margin-bottom: 20px !important
        }

        td.header {
            padding: 5px !important
        }

        input,
        select:not([class^=picker]),
        textarea {
            width: 100% !important;
            outline: 0 !important;
            -webkit-tap-highlight-color: rgba(255, 255, 255, 0);
            text-align: left !important;
            line-height: 1.2142em;
            padding: .67861em .5em !important;
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .15) !important;
            color: rgba(0, 0, 0, .8) !important;
            border-radius: .2857rem !important;
            -webkit-transition: background-color .2s ease, box-shadow .2s ease, border-color .2s ease;
            transition: background-color .2s ease, box-shadow .2s ease, border-color .2s ease;
            box-shadow: none;
            margin: 5px 0 20px
        }

        input,
        textarea {
            width: 100% !important
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: 0;
            border: 1px solid #058cf5
        }

        select {
            padding: .5em 1em .5em .75em !important;
            -webkit-background-size: 1600px 32px;
            -webkit-appearance: menulist !important
        }

        input[type=checkbox],
        input[type=radio] {
            line-height: 1em;
            margin: 0 .25em 0 0;
            padding: 0
        }

        input.button.r-button {
            box-shadow: none;
            color: #00A1CB !important;
            border: 2px solid #00A1CB !important;
            background: 0 0;
            text-shadow: none;
            display: inline-block;
            vertical-align: middle;
            font-weight: 300;
            margin: 10px 0 20px !important;
            text-decoration: none;
            text-align: center !important;
            transition: all .5s
        }

        .r-button,
        .r-mobile,
        .r-multicheckbox hr {
            display: inherit !important
        }

        input.button.r-button:active {
            position: relative
        }

        .r-message {
            position: relative;
            min-height: 1em;
            margin: 1em .5em;
            background: #efefef;
            padding: 1em 1.5em;
            line-height: 1.3;
            color: rgba(0, 0, 0, .8);
            -webkit-transition: opacity .2s ease, color .2s ease, background .2s ease, box-shadow .2s ease;
            transition: opacity .2s ease, color .2s ease, background .2s ease, box-shadow .2s ease;
            border-radius: .2857rem;
            box-shadow: 0 0 1px rgba(39, 41, 43, .15)inset, 0 0 0 0 transparent
        }

        .r-message.red {
            background-color: #ffe8e6;
            color: #d95c5c
        }

        .r-message b {
            font-weight: 400
        }

        .red {
            color: #d95c5c
        }

        .r-inline {
            display: inline-block !important
        }

        td#check {
            padding: 10px 0
        }

        body.payment table tbody tr td.red.requiredlabel {
            padding-left: 15px !important
        }

        body.modifyreg .red.requiredlabel {
            text-align: left !important;
            padding: 10px 0
        }

        table.r-multicheckbox {
            margin-top: 20px !important
        }

        .r-multicheckbox hr {
            border: 0;
            display: block;
            margin-top: 5px;
            height: 0;
            border-top: 1px solid rgba(0, 0, 0, .1);
            border-bottom: 1px solid rgba(255, 255, 255, .3);
            width: 100%
        }

        table.r-standard>tbody tr {
            display: block;
            width: 100%;
            padding: 10px !important
        }

        table.r-standard {
            margin-bottom: 20px !important
        }

        #totalcostdisplay {
            padding-left: 10px !important
        }

        #totalcostdisplay td,
        #totalcostdisplay td b {
            font-weight: 700 !important
        }

        .r-timeoutcontent {
            padding: 20px
        }

        .r-timeoutcontent p.standard {
            margin: 0 0 7px;
            line-height: 120%
        }

        .r-timeoutcontent p.standard a {
            text-decoration: underline;
            color: #00A1CB
        }

        .r-timeoutcontent p.standard b {
            color: #d95c5c
        }

        .r-attendeeoption hr,
        .r-guestoption hr {
            border: 0;
            display: block;
            margin: 10px 0;
            height: 0;
            border-top: 1px solid rgba(0, 0, 0, .1);
            border-bottom: 1px solid rgba(255, 255, 255, .3)
        }

        .r-attendeeoption-question,
        .r-guestoption-question {
            margin-bottom: 20px !important
        }

        #loading {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, .8);
            z-index: 1000
        }

        #loadingcontent {
            display: table;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%
        }

        #loadingspinner {
            display: table-cell;
            vertical-align: middle;
            width: 100%;
            text-align: center;
            font-size: larger
        }

        .spinner {
            height: 60px;
            width: 60px;
            margin: 0 auto;
            position: relative;
            -webkit-animation: rotation .6s infinite linear;
            -moz-animation: rotation .6s infinite linear;
            -o-animation: rotation .6s infinite linear;
            animation: rotation .6s infinite linear;
            border-left: 6px solid rgba(0, 174, 239, .15);
            border-right: 6px solid rgba(0, 174, 239, .15);
            border-bottom: 6px solid rgba(0, 174, 239, .15);
            border-top: 6px solid rgba(0, 174, 239, .8);
            border-radius: 100%
        }

        @-webkit-keyframes rotation {
            from {
                -webkit-transform: rotate(0deg)
            }

            to {
                -webkit-transform: rotate(359deg)
            }
        }

        @-moz-keyframes rotation {
            from {
                -moz-transform: rotate(0deg)
            }

            to {
                -moz-transform: rotate(359deg)
            }
        }

        @-o-keyframes rotation {
            from {
                -o-transform: rotate(0deg)
            }

            to {
                -o-transform: rotate(359deg)
            }
        }

        @keyframes rotation {
            from {
                transform: rotate(0deg)
            }

            to {
                transform: rotate(359deg)
            }
        }

        ul.r-mobile.pagebreaks {
            list-style: none;
            margin: 20px 0 0;
            padding: 0;
            display: block;
            border-bottom: 1px solid #ccc;
            border-top: 1px solid #ccc;
            height: 42px;
            background: #f5f5f5
        }

        ul.r-mobile.pagebreaks li {
            width: 12px;
            height: 12px;
            border: 1px solid #ccc;
            border-radius: 100%;
            float: left;
            display: inline;
            margin: 14px 5px 0;
            cursor: default;
            transition: all .5s
        }

        ul.r-mobile.pagebreaks li.all-previous,
        ul.r-mobile.pagebreaks li.all-previous:hover {
            background: #fff
        }

        ul.r-mobile.pagebreaks li.all-next,
        ul.r-mobile.pagebreaks li.all-next a {
            text-indent: -9999px
        }

        ul.r-mobile.pagebreaks li a {
            line-height: 30px;
            text-indent: -9999px;
            display: block;
            width: 100%;
            height: 100%
        }

        ul.r-mobile.pagebreaks li.selected {
            width: 200px;
            font-size: 14px !important;
            vertical-align: middle;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
            background: #fff !important;
            height: 30px;
            margin-top: 5px;
            line-height: 30px
        }

        ul.r-mobile.pagebreaks li.selected a {
            text-indent: 0
        }

        ul.r-mobile.pagebreaks li.selected {
            position: relative;
            border: 1px solid #ccc
        }

        ul.r-mobile.pagebreaks li.selected:after,
        ul.r-mobile.pagebreaks li.selected:before {
            top: 100%;
            left: 50%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none
        }

        ul.r-mobile.pagebreaks li.selected:after {
            border-color: #fff rgba(255, 255, 255, 0) rgba(255, 255, 255, 0);
            border-width: 10px;
            margin-left: -10px;
            transition: all .5s
        }

        ul.r-mobile.pagebreaks li.selected:before {
            border-color: #ccc rgba(204, 204, 204, 0) rgba(204, 204, 204, 0);
            border-width: 11px;
            margin-left: -11px;
            transition: all .5s
        }

        ul.r-mobile.pagebreaks li.selected:hover {
            background: #f0f0f0
        }

        ul.r-mobile.pagebreaks li.selected:hover:after {
            border-top-color: #f0f0f0;
            transition: all .5s
        }

        .r-cancel-btn,
        .r-remove-btn,
        a.clear-selection-label {
            color: #c65651 !important;
            background: #ffe8e6;
            border: 1px solid #c65651;
            font-weight: 400;
            font-size: 10px !important;
            padding: 3px 8px;
            border-radius: 3px;
            margin: 1em 0;
            display: inline-block;
            font-style: normal
        }

        .r-reg-cancel-link {
            margin-left: 1.5em
        }

        .r-upload-btn {
            color: #575757 !important;
            background: #f5f6fa;
            border: 1px solid #767676;
            font-weight: 400;
            font-size: 10px !important;
            padding: 3px 8px;
            border-radius: 3px;
            margin: 1em 0;
            display: inline-block;
            font-style: normal
        }

        .r-more-info-btn,
        a.more-info-btn {
            color: #5e9fde !important;
            background: #f5faff;
            border: 1px solid #cde2f5;
            font-weight: 400;
            font-size: 10px !important;
            padding: 3px 8px;
            border-radius: 3px;
            display: table;
            font-style: normal
        }

        .r-edit-btn {
            color: #575757 !important;
            background: #f5f6fa;
            border: 1px solid #767676;
            font-weight: 400;
            font-size: 10px !important;
            padding: 3px 8px;
            border-radius: 3px;
            margin: 1em 0;
            display: inline-block;
            font-style: normal
        }

        table#interests {
            margin: 0 0 20px !important;
            border-top: 1px solid #ccc !important;
            border-bottom: 1px solid #ccc !important
        }

        table#interests tbody tr {
            padding: 10px 0 !important
        }

        table#interests tbody tr td input {
            margin-top: 3px !important
        }

        div#Paginator1,
        div#Paginator2 {
            margin-top: 20px !important
        }

        div#Paginator1 td.line-height,
        div#Paginator2 td.line-height {
            padding-top: 10px !important
        }

        #Paginator1 table tbody tr td[align=left]>strong,
        #Paginator2 table tbody tr td[align=left]>strong {
            font-weight: 400;
            font-size: 80% !important;
            position: relative;
            left: -3px;
            bottom: -2px
        }

        table#ranking {
            border-top: 1px solid #ddd !important;
            border-bottom: 1px solid #ddd !important;
            padding-top: 5px !important;
            margin-bottom: 40px !important
        }

        table#ranking tbody>tr:first-child {
            margin-bottom: 5px !important;
            border-bottom: 1px solid #ccc !important;
            padding-bottom: 5px !important;
            min-width: 400px
        }

        table#ranking tbody>tr:first-child>td {
            display: inline-block !important;
            width: 25% !important;
            font-size: 70% !important;
            word-spacing: 300px;
            text-transform: capitalize;
            border-left: 1px solid #ddd !important;
            padding-left: 5px !important
        }

        table#ranking tbody>tr:first-child>td:not(:first-child) {
            text-align: center
        }

        table#ranking tbody>tr:not(:first-child) {
            font-size: 80% !important;
            height: 30px;
            line-height: 30px
        }

        table#ranking tbody>tr:not(:first-child)>td:not(:first-child) {
            border-left: 1px solid #eee !important;
            padding-left: 5px !important
        }

        table#ranking tbody>tr:not(:first-child)>td:not(:first-child)>input {
            float: none !important;
            margin: 0 0 0 50% !important;
            position: relative;
            left: -8px
        }

        body.matchmaking table#ranking tbody tr:first-child>td {
            width: 0 !important;
            padding: 0 !important;
            display: none
        }

        body.matchmaking table#ranking tbody tr:first-child>td:first-child,
        body.matchmaking table#ranking tbody tr:first-child>td:last-child,
        body.matchmaking table#ranking tbody tr:first-child>td:nth-child(2) {
            width: 33% !important;
            display: inline-block !important;
            padding: 5px !important;
            word-spacing: 0 !important
        }

        body.matchmaking table#ranking tbody tr:first-child>td:nth-child(2) {
            text-align: left !important
        }

        body.matchmaking table#ranking tbody tr:first-child>td:last-child {
            display: inline-block !important;
            padding-left: 14px !important;
            text-align: right !important;
            border-left: 1px solid transparent !important
        }

        body.matchmaking table#ranking tbody>tr:not(:first-child) td.r-mobile,
        table#ranking tbody>tr:not(:first-child) td.r-mobile input {
            display: inline-block !important
        }

        body.options a.clear-selection-labe {
            margin: 0 !important
        }

        body.record table.r-table td:first-child {
            width: 100% !important
        }

        div#transactiondiv {
            padding: 3px
        }

        div#transactiondiv table#attendee_information tbody>tr {
            width: 100% !important;
            display: block !important
        }

        div#transactiondiv table#attendee_information tbody>tr:not(:first-child) {
            padding: 8px !important
        }

        div#transactiondiv table#attendee_information tbody>tr td {
            width: 100% !important;
            display: block !important
        }

        div#transactiondiv table#attendee_information tbody>tr:not(:first-child) td {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            line-height: 120%
        }

        div#transactiondiv table#attendee_information tbody>tr:not(:first-child) td:first-child {
            font-weight: 700
        }

        body.attendeeinfo table.questionContainer.questionLabelLeft.r-standard tbody tr {
            padding: 10px 30px 20px 0 !important
        }

        body.attendeeinfo table.questionContainer.questionLabelLeft.r-standard tbody tr td.standard.questionInput .checkbox-container {
            margin: -1em -.9em 0 0 !important;
            float: right
        }

        body.attendeeinfo table.questionContainer.questionLabelLeft table.r-multicheckbox.standard tbody>tr>td span.checkbox-container {
            margin: -.25em .3em 0 0 !important;
            float: right
        }

        body.attendeeinfo table table.r-radio-list hr.r-mobile {
            border: 0;
            display: block;
            margin-top: 5px;
            height: 0;
            border-top: 1px solid rgba(0, 0, 0, .1);
            border-bottom: 1px solid rgba(255, 255, 255, .3)
        }

        body.travel table tbody tr td>b {
            display: block;
            padding-bottom: 10px !important;
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px !important
        }

        body.payment table.paymentmethod tbody>tr:first-child {
            margin-bottom: 10px !important
        }

        body.payment table.paymentmethod tbody>tr {
            display: block;
            padding: 5px !important
        }

        table#ranking tbody>tr:not(:first-child) td {
            width: 33% !important;
            display: inline-block;
            text-align: left !important;
            line-height: 100%;
            vertical-align: middle;
            padding: 5px !important;
            min-height: 30px !important
        }

        body.matchmaking table#ranking tbody>tr:not(:first-child) td.r-mobile,
        table#ranking tbody>tr:not(:first-child) td.r-mobile input {
            margin: 0 !important;
            padding: 0 !important
        }

        body.matchmaking table#ranking tbody>tr:not(:first-child) td.r-mobile {
            width: 66% !important;
            padding: 0 4px !important
        }

        body.matchmaking table#ranking tbody>tr:not(:first-child) td.r-mobile input {
            width: 100% !important
        }

        body.index p.r-reg-buttons a {
            display: block;
            clear: both;
            float: none;
            padding-left: 4px !important
        }

        hr {
            max-width: 100%
        }

        table.agenda-day-container>tbody tr {
            display: block;
            width: 100%;
            padding: 10px !important
        }

        table.agenda-day-container {
            margin-bottom: 20px !important
        }

        table.agenda-day-container>tbody tr td>table .standard.questionLabel {
            font-weight: 700
        }

        body.agenda table.agenda-day-container table.questionContainer table tbody tr td>div {
            margin: 10px 0;
            padding: 10px;
            border-bottom: 1px solid #ccc
        }

        span.r-indented {
            margin-left: 0 !important
        }

        a.r-small-btn-link {
            position: relative;
            display: inline-block;
            overflow: visible;
            margin: 8px 0 0;
            padding: 10px 14px;
            cursor: pointer;
            outline: 0;
            border: 0;
            background-color: #eee;
            background-image: -moz-linear-gradient(top, #eee, #eee);
            background-image: -ms-linear-gradient(top, #eee, #eee);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#eee), to(#eee));
            background-image: -webkit-linear-gradient(top, #eee, #eee);
            background-image: -o-linear-gradient(top, #eee, #eee);
            background-image: linear-gradient(top, #eee, #eee);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#eeeeee', endColorstr='#eeeeee', GradientType=0);
            -webkit-background-clip: padding;
            -moz-background-clip: padding;
            background-clip: padding;
            zoom: 1;
            z-index: 1;
            font-family: "Segoe UI", Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 14px;
            color: #333;
            min-width: 42px;
            text-shadow: #fff 0 1px 0;
            text-align: center;
            text-decoration: none;
            white-space: nowrap;
            vertical-align: inherit
        }

        body.cancelreg table.standard.r-attendee-info tbody>tr:first-child {
            display: none
        }

        body.cancelreg table.standard.r-attendee-info tbody>tr:nth-child(2) td:first-child::before {
            content: 'Reference #: '
        }

        body.cancelreg table.standard.r-attendee-info input.r-button {
            margin: 20px 0 0 12px !important
        }

        body.payment td.standard {
            line-height: 120%
        }

        table tbody tr td.header {
            margin-bottom: 10px !Important;
            padding: 10px !important
        }

        .sidebyside-icon-container {
            display: block
        }

        table.questionContainer.questionLabelLeft td.standard.questionInput i.fa.fa-user.sidebyside {
            color: #555;
            font-size: .8em !important;
            display: inline
        }

        table.questionContainer.questionLabelLeft td.standard.questionInput:nth-child(2) i.fa.fa-user.sidebyside::after {
            content: " 1 ";
            margin-right: 4px
        }

        table.questionContainer.questionLabelLeft td.standard.questionInput:nth-child(3) i.fa.fa-user.sidebyside::after {
            content: " 2 ";
            margin-right: 4px
        }

        body.additionalattendees table.standard.r-existing-attendees tbody>tr:first-child {
            display: none
        }

        body.additionalattendees table.standard.r-existing-attendees tbody>tr {
            padding: 10px !important
        }

        body.additionalattendees table.standard.r-existing-attendees tbody>tr:nth-child(n+2)>td:first-child::before {
            content: 'Reference #: ';
            font-weight: 700
        }

        body.additionalattendees table.standard.r-existing-attendees tbody tr td:nth-child(n+4) {
            margin: 10px 10px 10px 0 !important;
            width: 100% !important;
            text-align: justify;
            height: auto !important;
            line-height: 30px !important;
            border-radius: 4px;
            display: inline-block;
            overflow: hidden;
            overflow-wrap: break-word
        }

        body.additionalattendees table.standard.r-existing-attendees tbody tr td:nth-child(n+5) {
            width: auto !important;
            padding: 0 2px !important;
            text-align: center !important
        }

        .hidden_label {
            position: fixed !important;
            clip: rect(1px 1px 1px 1px);
            clip: rect(1px, 1px, 1px, 1px)
        }
    }

    @media only screen and (min-device-width:320px) and (max-device-width:480px) and (-webkit-min-device-pixel-ratio:2) {
        .optionclassiso {
            width: 220px !important
        }
    }

    @media only screen and (min-device-width:320px) and (max-device-width:480px) and (-webkit-min-device-pixel-ratio:2) and (orientation:portrait) {
        .optionclassiso {
            width: 220px !important
        }
    }

    @media only screen and (min-device-width:320px) and (max-device-width:480px) and (-webkit-min-device-pixel-ratio:2) and (orientation:landscape) {
        .optionclassiso {
            width: 220px !important
        }
    }

    @media only screen and (min-device-width:320px) and (max-device-width:568px) and (-webkit-min-device-pixel-ratio:2) {
        .optionclassiso {
            width: 250px !important
        }
    }

    @media only screen and (min-device-width:320px) and (max-device-width:568px) and (-webkit-min-device-pixel-ratio:2) and (orientation:portrait) {
        .optionclassiso {
            width: 250px !important
        }
    }

    @media only screen and (min-device-width:320px) and (max-device-width:568px) and (-webkit-min-device-pixel-ratio:2) and (orientation:landscape) {
        .optionclassiso {
            width: 250px !important
        }
    }

    @media only screen and (min-device-width:375px) and (max-device-width:667px) and (-webkit-min-device-pixel-ratio:2) {
        .optionclassiso {
            width: 280px !important
        }
    }

    @media only screen and (min-device-width:375px) and (max-device-width:667px) and (-webkit-min-device-pixel-ratio:2) and (orientation:portrait) {
        .optionclassiso {
            width: 280px !important
        }
    }

    @media only screen and (min-device-width:375px) and (max-device-width:667px) and (-webkit-min-device-pixel-ratio:2) and (orientation:landscape) {
        .optionclassiso {
            width: 280px !important
        }
    }

    @media only screen and (min-device-width:414px) and (max-device-width:736px) and (-webkit-min-device-pixel-ratio:3) {
        .optionclassiso {
            width: 280px !important
        }
    }

    @media only screen and (min-device-width:414px) and (max-device-width:736px) and (-webkit-min-device-pixel-ratio:3) and (orientation:portrait) {
        .optionclassiso {
            width: 280px !important
        }
    }

    @media only screen and (min-device-width:414px) and (max-device-width:736px) and (-webkit-min-device-pixel-ratio:3) and (orientation:landscape) {
        .optionclassiso {
            width: 280px !important
        }
    }

    @media only screen and (min-device-width:375px) and (max-device-width:812px) and (-webkit-min-device-pixel-ratio:3) {
        .optionclassiso {
            width: 280px !important
        }
    }

    @media only screen and (min-device-width:375px) and (max-device-width:812px) and (-webkit-min-device-pixel-ratio:3) and (orientation:portrait) {
        .optionclassiso {
            width: 280px !important
        }
    }

    @media only screen and (min-device-width:375px) and (max-device-width:812px) and (-webkit-min-device-pixel-ratio:3) and (orientation:landscape) {
        .optionclassiso {
            width: 280px !important
        }
    }

    td.content-width {
        width: 1%;
        white-space: nowrap
    }

    html #orig-nav {
        display: none
    }

    html .mobile-datepicker {
        display: table
    }

    html .legacy-datepicker {
        display: none
    }

    html #inner_content {
        padding: 20px 40px;
        height: 100%
    }

    html .requiredlabel {
        padding-bottom: 20px
    }

    html .picker__button--clear,
    html .picker__button--close,
    html .picker__button--today {
        font-size: 1.2em
    }

    html .title-bar {
        display: none
    }

    html .branding-hdr h1 {
        margin: 0
    }

    @media (min-width:801px) {
        html .picker__frame {
            max-width: 480px
        }

        html .picker__day {
            font-size: 14px
        }

        html .button.r-desktop {
            display: none !important
        }

        html .button.r-button {
            display: inline-block !important
        }

        html td.questionInput select {
            border: 0 solid rgba(0, 0, 0, .2);
            border-bottom-width: 1px
        }
    }

    html .red.r-message b {
        color: #d95c5c;
        font-size: 13px;
        padding: 7px;
        display: block;
        border-radius: 4px
    }

    html {
        min-height: 100%;
        background-color: transparent;
        background-position-x: 50%;
        background-position-y: 0;
        background-size: cover;
        background-repeat-x: no-repeat;
        background-repeat-y: no-repeat;
        background-attachment: fixed;
        background-origin: initial;
        background-clip: initial;
        font-family: Arial, sans-serif;
        background-image: url(<?php echo SITE_ROOT; ?>ereg/include/img/bkg-06.jpg)
    }

    html body {
        background-image: none !important;
        background-color: transparent;
        font-family: Arial, sans-serif
    }

    .header,
    .headercell,
    .maincell,
    .maincellover,
    .off,
    .on,
    .red,
    .redLabel,
    .selectbox,
    .standard,
    a.footer:link,
    a.footer:visited,
    a.menu:link,
    a.menu:visited,
    a.menu_standard:link,
    a.menu_standard:visited,
    a.redLabel:link,
    a.redLabel:visited,
    div,
    font,
    input,
    p,
    select,
    td,
    textarea {
        font-family: Arial, sans-serif
    }

    td.questionInput span.r-indented.standard {
        line-height: normal
    }

    #inner_content {
        position: relative
    }

    #inner_content div#inner-content-related-vars-container {
        width: 100%;
        height: 50px;
        position: absolute;
        left: 0
    }

    input:disabled,
    select:disabled {
        color: grey !important
    }

    td.questionInput select:not([class^=picker]) {
        background: ivory url(insolindia/ereg/include/img/select-arw.png) 97% 50% no-repeat
    }

    .questionContainer input,
    .questionContainer select:not([class^=picker]),
    .questionContainer textarea,
    .r-multicheckbox label,
    .r-radio-list label {
        font-size: 12px
    }

    .zero_four_text_password {
        color: #2f2f2f;
        border-radius: 4px;
        min-height: 32px;
        line-height: 24px;
        padding: 0 30px 0 10px
    }

    .zero_four_select {
        background: ivory url(insolindia/ereg/include/img/select-arw.png) 97% 50% no-repeat;
        background-size: 10px;
        font-size: 12px;
        text-transform: uppercase;
        -webkit-appearance: none;
        -moz-appearance: none;
        max-width: 100%
    }

    @media (min-width:801px) {
        td .questionLabel.widthlabelSidebySide {
            width: 70% !important;
            background-color: #e3eaf0 !important
        }

        .questionContainer.questionLabelAbove tbody tr>td:last-child {
            width: auto
        }

        .questionContainer.questionLabelAbove tbody tr>td:last-child.sidebysidequeAbove {
            width: 265px !important;
            text-align: right !important
        }

        .displaytblcell {
            display: table-cell !important
        }

        .sidebysidetxt {
            width: 260px !important;
            text-align: right !important
        }

        .questionLabelAbove tbody tr td.sidebysidequeAbove {
            height: 58px !important;
            background: #e3eaf0 !important
        }

        select[class^=picker] {
            padding: 0
        }

        .category-selection-tr {
            width: 100%;
            display: block
        }

        body.agenda td.questionInput,
        body.agenda td.questionLabel {
            padding: 9px 10px !important
        }

        body.agenda table[data-questiontype="31"],
        body.agenda table[data-questiontype="30"],
        body.agenda table[data-questiontype="32"] {
            display: table
        }

        body.agenda table[data-questiontype="31"] tbody,
        body.agenda table[data-questiontype="30"] tbody,
        body.agenda table[data-questiontype="32"] tbody {
            display: table;
            width: 100%
        }

        body.agenda table[data-questiontype="31"] tbody tr,
        body.agenda table[data-questiontype="30"] tbody tr,
        body.agenda table[data-questiontype="32"] tbody tr {
            display: table-row
        }

        body.agenda table[data-questiontype="31"] tbody tr tr:first-child,
        body.agenda table[data-questiontype="30"] tbody tr tr:first-child,
        body.agenda table[data-questiontype="32"] tbody tr tr:first-child {
            background: 0 0 !important
        }

        body.agenda table[data-questiontype="31"] tbody tr:not(:first-child),
        body.agenda table[data-questiontype="30"] tbody tr:not(:first-child),
        body.agenda table[data-questiontype="32"] tbody tr:not(:first-child) {
            background: #fff
        }

        body.agenda table[data-questiontype="32"] input.shadow {
            width: auto !important
        }

        body.agenda table[data-questiontype="32"] tr tr:first-child {
            background: 0 0 !important
        }

        body.agenda table[data-questiontype="32"] tr:not(:first-child) {
            background: #fff
        }

        body.agenda .questionLabelAbove tbody tr:nth-child(2)>td:first-child {
            background: #fff !important
        }

        body.options table[data-questiontype="40"] .questionInput input[type=checkbox] {
            float: none !important;
            display: inline-block
        }

        body.options table[data-questiontype="40"] .questionInput span.r-indented {
            display: inline-block !important;
            margin-left: 0 !important
        }

        body.options table[data-questiontype="41"] .questionInput span.r-indented {
            display: inline-block !important;
            margin-left: 0 !important;
            max-width: 97%
        }

        body.options table[data-questiontype="41"] .questionInput input {
            float: none !important;
            margin-top: 0;
            margin-bottom: 13px
        }

        body.options table[data-questiontype="41"] .questionInput input.btnposition {
            float: left !important;
            margin-top: 2px !important
        }

        body.options table[data-questiontype="43"] {
            background: #e3eaf0
        }

        body.options table[data-questiontype="43"] td.questionInput {
            background-color: transparent
        }

        table.questionContainer.rmp_question_container td.questionLabel {
            height: auto
        }

        .date_filters .parameter .r-mobile {
            display: block
        }

        td.questionInput,
        td.questionLabel {
            vertical-align: top;
            padding: 9px 10px
        }

        table[data-questiontype="41"] td.questionLabel,
        table[data-questiontype="4"] td.questionLabel {
            vertical-align: top
        }

        input[type=checkbox] {
            border-style: none
        }

        label:empty {
            display: none
        }

        html td.questionLabel {
            width: 30% !important;
            height: 58px;
            font-size: 12px
        }

        html td.questionInput {
            width: 70% !important
        }

        html td.questionInput input[type=password],
        html td.questionInput input[type=text],
        html td.questionInput textarea {
            -webkit-appearance: none;
            -webkit-font-smoothing: antialiased;
            -webkit-rtl-ordering: logical;
            -webkit-user-select: text;
            background-position: 96% 50%;
            border-image-outset: 0;
            border-image-repeat: stretch;
            border-image-slice: 100%;
            border-image-source: none;
            border-image-width: 1;
            border-radius: 0;
            border: 0 solid rgba(0, 0, 0, .2);
            border-bottom-width: 1px;
            box-shadow: none;
            box-sizing: border-box;
            color: #2f2f2f;
            cursor: auto;
            display: inline-block;
            font-size: 12px;
            min-height: 32px;
            letter-spacing: normal;
            line-height: 24px;
            margin: 0;
            outline: #2f2f2f 0;
            padding: 0 8px;
            text-align: left;
            text-indent: 0;
            text-rendering: auto;
            text-shadow: none;
            text-transform: none;
            word-spacing: 0;
            writing-mode: lr-tb;
            -webkit-writing-mode: horizontal-tb
        }

        html td.questionInput input[type=file] {
            position: relative;
            border: none
        }

        html td.questionInput table.r-multicheckbox td span.checkbox-container {
            display: inline-block
        }

        html td.questionInput table.r-multicheckbox td span.checkbox-container input {
            margin-bottom: 13px
        }

        html td.questionInput select:not([class^=picker]) {
            max-width: 100%;
            padding: 10px 18px 6px 8px;
            border: 0 solid rgba(0, 0, 0, .2);
            border-bottom-width: 1px;
            border-radius: 0;
            background: ivory url(<?php echo SITE_ROOT; ?>ereg/include/img/select-arw.png) 98% 50% no-repeat;
            color: #2f2f2f;
            font-size: 12px;
            font-weight: 400;
            text-indent: 1px;
            text-overflow: ellipsis;
            outline: 0;
            -webkit-appearance: none;
            -moz-appearance: none
        }

        html td.questionInput a.r-upload-btn {
            line-height: 32px;
            text-decoration: underline
        }

        html td.questionInput a.r-upload-btn:hover {
            text-decoration: none
        }

        html td.questionInput span.r-indented.standard {
            line-height: 42px
        }

        html input.button.r-button {
            background-image: none;
            height: 46px;
            line-height: 23px;
            margin-bottom: 0;
            padding: 10px 16px;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            min-width: 220px;
            cursor: pointer
        }

        html body.agenda td.questionInput span.standard,
        html body.agenda td.questionLabel span.standard {
            line-height: normal
        }

        body.agenda .agenda-day-container td.questionInput {
            height: 58px;
            font-size: 12px
        }

        hr.r-mobile {
            display: none
        }

        td.questionInput tr.r-mobile {
            display: block
        }

        body.agenda td.questionInput,
        body.agenda td.questionLabel {
            line-height: normal
        }
    }

    @media (max-width:800px) {

        body.matchmaking input[type=checkbox],
        body.matchmaking input[type=radio] {
            margin: 0 .25em 0 0 !important
        }

        body.options table.questionContainer div {
            padding: 5px
        }

        body.options input[type=radio] {
            margin: 9px .25em 0 0 !important
        }

        body.options table[data-questiontype="17"] input[type=radio] {
            margin: 0 !important
        }

        table.r-multicheckbox {
            padding-top: 10px !important
        }

        table.r-multicheckbox hr {
            width: 100%
        }

        table td:not([class^=picker]).questionLabel {
            padding: 5px !important
        }

        table td:not([class^=picker]).questionLabel:empty {
            display: none
        }

        body.attendeeinfo table.questionContainer.questionLabelLeft.r-standard tbody tr {
            padding: 10px 0 20px !important
        }

        body.attendeeinfo table.questionContainer.questionLabelLeft.r-standard tbody tr td.standard.questionInput .checkbox-container,
        body.newreg .checkbox-container {
            margin: -25px 6px 0 0 !important;
            float: right
        }

        body.newreg table[data-questiontype="17"] tr {
            padding: 10px 0 20px !important
        }

        body.newreg table[data-questiontype="17"] tr label {
            display: inline-block
        }

        body.newreg table[data-questiontype="17"] hr {
            border: 0;
            display: block;
            margin-top: 5px;
            height: 0;
            border-top: 1px solid rgba(0, 0, 0, .1);
            border-bottom: 1px solid rgba(255, 255, 255, .3)
        }

        .select-hotel-table .select-hotel-row {
            margin-bottom: 14px !important
        }

        select[class^=picker] {
            height: 3em
        }

        body.selecttravel .select-travel-row {
            margin-bottom: 14px !important
        }
    }

    body.agenda table[data-questiontype="0"],
    body.attendeeinfo table[data-questiontype="0"],
    body.hotel table[data-questiontype="0"],
    body.options table[data-questiontype="0"],
    body.payment table[data-questiontype="0"],
    body.travel table[data-questiontype="0"] {
        background: #e3eaf0
    }

    body.agenda table[data-questiontype="0"] td.questionInput,
    body.attendeeinfo table[data-questiontype="0"] td.questionInput,
    body.hotel table[data-questiontype="0"] td.questionInput,
    body.options table[data-questiontype="0"] td.questionInput,
    body.payment table[data-questiontype="0"] td.questionInput,
    body.travel table[data-questiontype="0"] td.questionInput {
        background-color: transparent
    }

    .new-desktop-nav {
        position: relative;
        background-color: #1c2544
    }

    .new-desktop-nav #r-breadcrumbs {
        background-color: #1c2544;
        border-right: 1px solid #33394c;
        border-left: 1px solid #0f131e;
        text-transform: capitalize
    }

    .new-desktop-nav #r-breadcrumbs .crumbs li {
        font-size: 12px
    }

    .new-desktop-nav #r-breadcrumbs .crumbs li a {
        font-size: 12px !important;
        font-family: Arial, sans-serif !important
    }

    .new-desktop-nav #r-breadcrumbs .crumbs li.off a,
    .new-desktop-nav #r-breadcrumbs .crumbs li.on a,
    .new-desktop-nav #r-breadcrumbs .crumbs li.previous-step a {
        color: #fff !important
    }

    @media (min-width:801px) {
        .new-desktop-nav {
            position: relative;
            height: auto;
            width: 100%;
            display: table
        }

        .new-desktop-nav #r-breadcrumbs {
            border-right: 1px solid #33394c;
            border-left: 1px solid #0f131e;
            height: auto;
            padding: 0;
            display: table
        }

        .new-desktop-nav #r-breadcrumbs .crumbs {
            height: auto
        }

        .new-desktop-nav #r-breadcrumbs .crumbs li {
            border-right: 1px solid #0f131e;
            border-left: 1px solid #33394c
        }

        .new-desktop-nav #r-breadcrumbs ul.crumbs {
            display: table-row;
            width: 100%;
            height: auto
        }

        .new-desktop-nav #r-breadcrumbs ul.crumbs li {
            display: table-cell;
            width: auto;
            height: auto;
            padding: 0
        }

        .new-desktop-nav #r-breadcrumbs ul.crumbs li.on {
            -webkit-box-shadow: inset 0 3px 11px 2px rgba(0, 0, 0, .2);
            box-shadow: inset 0 3px 11px 2px rgba(0, 0, 0, .2);
            background: #0d112b;
            background: -moz-linear-gradient(top, #0d112b 0, #121c3a 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #0d112b), color-stop(100%, #121c3a));
            background: -webkit-linear-gradient(top, #0d112b 0, #121c3a 100%);
            background: -o-linear-gradient(top, #0d112b 0, #121c3a 100%);
            background: -ms-linear-gradient(top, #0d112b 0, #121c3a 100%);
            background: linear-gradient(to bottom, #0d112b 0, #121c3a 100%);
            text-decoration: none;
            border-left: 1px solid #0f131e
        }

        .new-desktop-nav #r-breadcrumbs ul.crumbs li a {
            padding: 1.1em
        }

        .new-desktop-nav #r-breadcrumbs ul.crumbs span {
            display: none
        }

        .new-desktop-nav #r-breadcrumbs {
            max-width: 100%;
            position: relative;
            margin: 0 auto
        }

        .new-desktop-nav #r-breadcrumbs ul.crumbs {
            list-style: none;
            text-align: center;
            max-width: 100%
        }

        .new-desktop-nav #r-breadcrumbs ul.crumbs li {
            margin: 0;
            text-align: center
        }

        .new-desktop-nav #r-breadcrumbs ul.crumbs li.off,
        .new-desktop-nav #r-breadcrumbs ul.crumbs li.previous-step {
            font-weight: 400
        }

        .new-desktop-nav #r-breadcrumbs ul.crumbs li.off a {
            cursor: default;
            opacity: .8
        }

        .new-desktop-nav #r-breadcrumbs ul.crumbs li.on {
            font-weight: 400
        }

        .new-desktop-nav #r-breadcrumbs ul.crumbs li a {
            margin: 0;
            display: block
        }
    }

    .needs-table-color {
        background-color: #8287a0
    }

    .needs-tablerowcolor1 {
        background-color: #fff
    }

    .needs-tablerowcolor2 {
        background-color: #eee
    }

    input.button.r-button {
        background-color: #0053a0;
        border: 2px solid #1c2544 !important;
        border-radius: 6px !important;
        color: #fff !important;
        font-family: Open Sans, sans-serif !important;
        font-weight: 400;
        font-size: 16px !important;
        cursor: pointer;
        -webkit-appearance: none
    }

    input.button.r-button:active {
        position: relative
    }

    input.button.r-button:hover {
        background-color: #ed1b2e !important;
        border: 2px solid #ed1b2e !important;
        color: #fff !important
    }

    .nav-related-vars-container {
        position: relative
    }

    .branding-hdr {
        background-color: rgba(255, 255, 255, .6)
    }

    .branding-hdr h1 img {
        max-width: 100%
    }

    .logo-img-container {
        width: auto !important;
        height: auto !important
    }

    #inner_content,
    .r-cancel-btn-tr {
        background-color: #fff
    }

    .linkSnippetVersion {
        background-color: #1c2544
    }

    table[data-questiontype="43"] td.questionInput,
    table[data-questiontype="0"] td.questionInput,
    td.questionLabel {
        background-color: #e3eaf0;
        text-transform: capitalize;
        color: #000;
        font-family: Open Sans, sans-serif !important;
        font-size: 12px
    }

    td.questionLabel label {
        text-transform: capitalize;
        color: #000;
        font-family: Open Sans, sans-serif !important;
        font-size: 12px
    }

    td.questionInput {
        background-color: #fff !important;
        box-sizing: border-box
    }

    td.questionInput input:not([name=apply_code]):not(.r-button),
    td.questionInput select:not([class^=picker]),
    td.questionInput textarea {
        background-color: ivory !important
    }

    body.payment input:not([name=apply_code]):not(.r-button),
    body.payment select:not([class^=picker]),
    body.payment textarea {
        background-color: ivory
    }

    body.payment select {
        -webkit-appearance: none
    }

    .questionLabelAbove {
        display: table
    }

    .questionLabelAbove tbody,
    .questionLabelAbove tbody tr {
        width: 100%
    }

    .questionLabelAbove tbody tr:first-child>td:nth-child(2) {
        padding-left: 10px
    }

    .questionLabelAbove tbody tr:nth-child(2)>td:first-child {
        background: #fff
    }

    .questionLabelAbove tbody tr td {
        height: auto;
        background: 0 0
    }

    .questionLabelAbove tbody tr>td:last-child {
        display: table;
        width: 100% !important
    }

    .questionLabelAbove>tbody>tr:first-child {
        background: #e3eaf0
    }

    .questionLabelAbove>tbody tr:nth-child(2)>td:first-child {
        background: #fff
    }

    .questionLabelHeading tbody tr {
        background: #e3eaf0 !important
    }

    table.questionLabelAbove table.r-multicheckbox tr:first-child {
        background-color: ivory
    }

    .error {
        border: 1px solid #f99 !important
    }

    input.button.h-button {
        background-color: #fff;
        border: 1px solid #2c506c !important;
        border-radius: 4px !important;
        color: #000 !important;
        font-family: Open Sans !important;
        font-weight: 400;
        font-size: 16px !important;
        cursor: pointer;
        -webkit-appearance: none
    }

    input.button.h-button:active {
        position: relative
    }

    input.button.h-button:hover {
        background-color: #90b2cc !important;
        border: 2px solid #2c506c !important;
        color: #fff !important
    }

    .hotel-background-info {
        margin: 0 !important;
        background-color: #e3eaf0 !important;
        text-transform: uppercase !important;
        color: #000 !important;
        height: 64px
    }

    .hotel-background-info span.header-label {
        font-size: 20px !important;
        font-family: Open Sans !important;
        padding-top: 10px;
        position: absolute
    }

    .background-info {
        margin: 0 !important;
        background-color: #e3eaf0 !important;
        color: #000 !important;
        height: 64px
    }

    .background-info span.date-label {
        font-size: 16px !important;
        font-family: Open Sans !important;
        text-transform: uppercase !important
    }

    .hotel-header,
    span.distance {
        text-transform: capitalize !important;
        color: #000 !important
    }

    .hotel-header div,
    .hotel-header span,
    span.distance {
        font-size: 12px !important;
        font-family: Open Sans !important
    }

    a.hotel-website {
        color: #000 !important;
        font-size: 12px !important;
        font-family: Open Sans !important;
        word-wrap: break-word
    }

    .hotel-title {
        text-transform: capitalize !important;
        color: #000 !important;
        font-size: 18px !important;
        font-family: Open Sans !important
    }

    .hotel-rating,
    span#hd-address {
        text-transform: capitalize !important;
        color: #000 !important;
        font-size: 14px !important;
        font-family: Open Sans !important
    }

    .backlist-hotel {
        text-transform: capitalize !important;
        color: #000 !important;
        font-size: 15px !important;
        font-family: Open Sans !important
    }

    .hotel-more-info,
    .hotel-more-info-ans {
        text-transform: capitalize !important;
        color: #000 !important;
        font-size: 15px !important;
        font-family: Tahoma !important
    }

    .shopping-cart {
        background-color: #e3eaf0 !important
    }

    .hotel-cost h5,
    .hotel-cost h6,
    .hotel-cost h6 label,
    .total-cost h5,
    .total-cost h6,
    .total-cost h6 label {
        text-transform: capitalize !important;
        color: #000 !important;
        font-size: 15px !important;
        font-family: Tahoma !important;
        padding: 0
    }

    .checkout-items span,
    .price-text-web {
        text-transform: capitalize !important;
        color: #000 !important;
        font-size: 10px !important;
        font-family: Tahoma !important
    }

    .roomtype-title,
    .row.new-row.room-type-header div {
        font-size: 15px !important;
        text-transform: capitalize !important;
        color: #000 !important;
        font-family: Tahoma !important
    }

    .description {
        font-size: 10px !important;
        text-transform: capitalize !important;
        color: #000 !important;
        font-family: Tahoma !important
    }

    .price-display {
        color: #000 !important
    }

    .price-display label {
        font-family: Tahoma !important;
        font-size: 14px !important
    }

    .input-group-btn .btn {
        background-color: #5886ac !important;
        border: none !important;
        color: #fff !important
    }

    .form-control:focus {
        border: 1px solid #5886ac !important
    }

    .ui-datepicker {
        border: 7px solid #5886ac !important
    }

    .ui-datepicker .ui-datepicker-header,
    .ui-datepicker .ui-datepicker-next:hover,
    .ui-datepicker .ui-datepicker-prev:hover,
    .ui-datepicker .ui-state-active {
        background-color: #5886ac !important
    }

    .ui-datepicker .ui-datepicker-prev {
        border-right: 2px solid #5886ac !important
    }

    .ui-datepicker .ui-datepicker-next {
        border-left: 2px solid #5886ac !important
    }

    .nav-tabs>li.active>a,
    .nav-tabs>li.active>a:focus,
    .nav-tabs>li.active>a:hover {
        background-color: #e3eaf0 !important
    }

    .nav-tabs>li>a,
    .nav-tabs>li>a:focus,
    .nav-tabs>li>a:hover {
        background-color: #fff !important
    }

    .hotel-details a:hover {
        color: #0000a2
    }

    .reg-header-container {
        background-color: #fff !important
    }

    ul.hotel-tabs li a {
        color: #000 !important
    }

    div#hotelCount {
        font-weight: 700;
        font-size: 16px !important;
        text-transform: none !important;
        color: #000 !important;
        font-family: Open Sans !important
    }

    span.hotelName {
        font-size: 18px !important;
        text-transform: capitalize !important;
        color: #000 !important;
        font-family: Tahoma !important
    }

    span.address,
    span.distance {
        font-size: 12px !important;
        text-transform: capitalize !important;
        color: #000 !important;
        font-family: Tahoma !important
    }

    .hotel-width-price,
    .hotel-width-star {
        font-size: 14px !important;
        text-transform: none !important;
        color: #000 !important;
        font-family: Tahoma !important
    }

    span#distance {
        font-size: 12px !important;
        text-transform: capitalize !important;
        color: #000 !important;
        font-family: Open Sans !important
    }

    .options .questionLabelAbove tbody tr:nth-child(2)>td:first-child {
        background: #e3eaf0
    }

    ul.r-mobile.pagebreaks li {
        color: #000 !important;
        background-color: #fff !important
    }

    ul.r-mobile.pagebreaks li.selected {
        background-color: #e3eaf0 !important
    }

    ul.r-mobile.pagebreaks li.selected:hover {
        background-color: #dadbda
    }

    ul.r-mobile.pagebreaks li:hover {
        color: #888 !important
    }

    ul.r-mobile.pagebreaks li a {
        color: #000 !important
    }

    ul.r-mobile.pagebreaks li a:hover {
        color: #888 !important
    }

    @media (min-width:801px) {
        ul.r-mobile.pagebreaks {
            display: table;
            width: 100%;
            padding-left: 0
        }

        ul.r-mobile.pagebreaks li {
            box-sizing: border-box;
            display: table-cell;
            float: none;
            font-size: 14px;
            line-height: 40px;
            list-style-type: none;
            margin-bottom: -1px;
            position: relative;
            text-align: center;
            width: 1%;
            border: 1px solid transparent;
            border-bottom: 1px solid #ddd;
            border-radius: 6px 6px 0 0
        }

        ul.r-mobile.pagebreaks li.selected {
            border: 1px solid #ddd;
            border-bottom: 1px solid #fff
        }

        ul.r-mobile.pagebreaks li a {
            color: #333;
            width: 100%;
            border-radius: 6px 6px 0 0;
            display: block
        }

        ul.r-mobile.pagebreaks li a:hover {
            color: #888;
            background-color: rgba(243, 241, 233, .4)
        }
    }

    .branding-hdr {
        padding: 20px 0
    }

    .reg-header-container {
        padding: 5px 15px
    }

    .reg-header-container td.language-selector-container {
        padding-left: 15px !important;
        padding-right: 15px !important
    }

    tr td.header:not(.reg-header-header) {
        background-color: #8287a0
    }

    body.payment table#attendee_information td.header {
        background-color: transparent
    }

    .requiredlabel {
        color: #aaa
    }

    .red.r-message b {
        color: #d95c5c;
        font-size: 12px;
        padding: 7px;
        display: block;
        border-radius: 4px
    }

    .picker__header select::-ms-expand,
    .questionInput select::-ms-expand {
        display: none
    }

    table.q_page_break {
        display: none
    }

    div#transactiondiv table#attendee_information tbody>tr:first-child {
        background-color: #8287a0
    }

    @media (min-width:801px) {
        html {
            min-width: 940px
        }

        html #outer_table {
            width: auto;
            min-width: 940px
        }

        html #inner_content {
            max-width: 940px
        }

        html .questionContainer {
            width: 100%
        }

        html .r-reg-buttons a {
            display: inline-block
        }

        html table.agenda-day-container {
            border: none !important
        }

        html table.agenda-day-container tbody tr td:not(.questionLabel),
        html table.agenda-day-container tbody tr td:not(.standard) {
            padding: 0
        }

        html tr.discount-code-tr td.questionLabel {
            vertical-align: top
        }
    }

    @media (max-width:800px) {
        ul.r-mobile.pagebreaks li.selected:after {
            border-top-color: #e3eaf0
        }

        ::-ms-check,
        input[type=checkbox] {
            margin: 5px 0 20px !important
        }

        select {
            -webkit-appearance: none !important
        }

        table.agenda-day-container>tbody tr:first-child {
            background: 0 0
        }

        table.agenda-day-container>tbody tr {
            padding: 0 !important;
            background-color: transparent !important
        }

        table.agenda-day-container>tbody tr td {
            padding: 10px !important
        }

        table.r-standard>tbody tr {
            border-bottom: none !important
        }

        table.r-standard {
            margin-bottom: 0 !important
        }

        table.r-standard>tbody tr.discount-code-tr {
            padding: 0 !important
        }

        .reg-header-container td.language-selector-container select {
            background: ivory url(<?php echo SITE_ROOT; ?>ereg/include/img/select-arw.png) 97% 50% no-repeat
        }
    }

    @media all and (device-width:768px) and (device-height:1024px) and (orientation:portrait) {
        .checkbox-container input {
            margin-top: 0 !important
        }
    }

    body.agenda .questionContainer .questionInput.standard a.more-info-btn,
    body.agenda .questionContainer .questionInput.standard label {
        font-size: 12px;
        vertical-align: top
    }

    .ereg_agenda_erros {
        position: relative;
        padding-right: 20px;
        background: #ecafaf;
        border: 1px solid #998D8D;
        border-radius: 2px;
        margin-bottom: 5px
    }

    .ereg_agenda_erros p,
    .ereg_agenda_erros span,
    .ereg_agenda_erros ul {
        color: #333
    }

    .ereg_agenda_erros p {
        font-weight: 700;
        margin: 5px 10px
    }

    .ereg_agenda_erros ul {
        padding: 0 25px;
        margin: 5px 0
    }

    .ereg_agenda_erros span {
        position: absolute;
        top: 5px;
        right: 7px;
        cursor: pointer
    }
    </style>
    <style id="customizer-custom-styles">
    /* Header */
    .branding-hdr {}

    /* Navigation */
    .nav-related-vars-container {}

    /* Content */
    #inner_content {}
    </style>
    <link rel="stylesheet" type="text/css"
        href="//staticcdn.eventscloud.com/libs/css/cookieconsent2/3.0.3/cookieconsent.min.css" />
    <script src="//staticcdn.eventscloud.com/libs/js/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
    <script>
    window.addEventListener("load", function() {
        window.cookieconsent.initialise({
            "palette": {
                "popup": {
                    "background": "#000",
                    "text": "#fff",
                    "link": "#fff"
                },
                "button": {
                    "background": "#fff",
                    "text": "#000"
                }
            },
            "theme": "classic",
            "position": "bottom",
            "content": {
                "message": "This website uses cookies for proper functioning and enhancing the user experience. Clicking \"Continue\" acknowledges your consent.",
                "dismiss": "Continue",
                "link": "Learn More",
                "href": "https://www.etouches.com/event-software/privacy-policy/"
            }
        })
    });
    </script>
</head>

<body class="newreg"><a href="#maincontentaccessible" class="skipaccessible">Skip to Main Content</a>
    <table id="outer_table" role="presentation" width="750" cellspacing="0" cellpadding="0" class="needs-innerpagecolor"
        align="center" role="main">
        <tr data-relatedvars="branding-bg-color,branding-padding">
            <td class="branding-hdr" align="center">
                <h1 aria-label="">
                    <div class="logo-img-container"
                        style="display: block; position:relative;width:1000px;height:400px;">

                        <a target="_blank" href="http://"><img
                                src="<?php echo SITE_ROOT; ?>ereg/file_uploads/webinaroption2thinlogo.jpg" border="0"
                                alt="<?php echo $event_data; ?>" /></a>
                    </div>
                </h1>
                <div class="ve-header" style="display: none;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="mobile-user-profile col-2 col-xs-2 col-sm-2 d-sm-none"><button
                                    class="user-profile-trigger"><i class="fa fa-user-o" aria-hidden="true"><span
                                            class="sr-only">User Profile Navigator</span></i><span
                                        class="profile-edit-icon"></span></button></div>
                            <div align="center" class="header-title col-xs-8 col-sm-8 col-md-12"></div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <!-- JS / Breadcrumbs / Menu toggle / Pagebreak -->
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            var currentTab = $('#r-breadcrumbs ul li.on').html();

            $('#r-breadcrumbs span.r-breadcrumb-menu-title on').html(currentTab);

            $('.r-crumb-trigger').click(function() {
                $('#r-breadcrumbs ul li').toggleClass("visible");
                $('#r-breadcrumbs span.r-count').attr("aria-expanded", function(index, attr) {
                    return attr == "false" ? "true" : "false";
                });
            });
            $('#r-breadcrumbs span.r-count').keydown(function(e) {
                if (e.keyCode == 32 || e.keyCode == 13) {
                    e.preventDefault();
                    $('#r-breadcrumbs ul li').toggleClass("visible");
                    $(this).attr("aria-expanded", function(index, attr) {
                        return attr == "false" ? "true" : "false";
                    });
                }
            });

            $('ul.r-mobile.pagebreaks li.selected').prevAll('li').addClass('all-previous');
            $('ul.r-mobile.pagebreaks li.selected').nextAll('li').addClass('all-next');

            $(".notify_mod").attr("title", "");



            //For accessibility - skip link
            $(".skipaccessible").keypress(function(event) {
                var skipTo = "#" + this.href.split('#')[1];
                // Setting 'tabindex' to -1 takes an element out of normal  tab flow but allows it to be focused via javascript
                $(skipTo).attr('tabindex', -1).on('blur focusout', function() {
                    $(this).removeAttr('tabindex');
                }).focus(); // focus on the content container
            });

        });
        </script>

        <tr class="nav-related-vars-container" class="nav-related-vars-container">
            <td class="new-desktop-nav"
                data-relatedvars="nav-text-off-color,nav-text-capitalization,nav-padding,nav-text-font-size,nav-bg-color,nav-grad-start,nav-grad-stop,nav-border-right-color,nav-border-left-color,nav-text-on-color,nav-text-on-font">
                <div id="r-breadcrumbs" class="r-mobile" class="r-mobile" role="navigation" aria-label=”Progress”><span
                        class="r-breadcrumb-menu-title"></span>
                    <ul class="crumbs" role="application"><span role="button" tabindex="0" aria-label="navigation menu"
                            aria-expanded="false" class="r-count"><span
                                class="r-crumb-trigger fa fa-bars"></span></span>
                        <li class="previous-step"><a class="menu_standard" id="Welcome"
                                href="<?php echo SITE_ROOT; ?>ereg/index.php?eventid=200225862&">Welcome</a></li>
                        <li class="off" aria-disabled="true"><a href="#" tabindex="-1">Attendee Information</a></li>
                        <li class="off" aria-disabled="true"><a href="#" tabindex="-1">Registration Record</a></li>
                </div>
                <table width="100%" cellspacing="0" cellpadding="2" id="orig-nav" class="r-desktop" role="navigation">
                    <tr>
                        <td align="center" width="33%" class="previous-step"><a class="menu_standard" id="Welcome"
                                href="<?php echo SITE_ROOT; ?>ereg/index.php?eventid=200225862&">Welcome</a></td>
                        <td align="center"><img src="/images/arrow.png" border="0" width="13" height="10"
                                alt="arrow pointing to the right" /></td>
                        <td align="center" width="33%" class="off">Attendee Information</td>
                        <td align="center"><img src="/images/arrow.png" border="0" width="13" height="10"
                                alt="arrow pointing to the right" /></td>
                        <td align="center" width="33%" class="off">Registration Record</td>
            </td>
        </tr>
    </table>
    <tr>
        <td class="reg-header-cont-cont">
            <table data-relatedvars="header-bg-color,table-header-color" width="100%" cellspacing="0" cellpadding="2"
                class="reg-header-container">
                <table width="100%" cellspacing="0" cellpadding="2" class="reg-header-container">
                    <tr>
                        <td class="header reg-header-header"><?php echo $event_data; ?></td>
                    </tr>
                </table>
        </td>
    </tr>
    <tr>
        <td id="inner_content" valign="top">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top">
                        <div class="container-fluid header-content-container"></div><a name="maincontentaccessible"
                            id="maincontentaccessible"></a>


                        <form id="form" method="post" action="newreg.php?eventid=200225862&"
                            enctype="multipart/form-data" autocomplete="on">
                            <input type="hidden" id="action" name="action" value="submit" />
                            <input type="hidden" name="eventid" value="200225862" />
                            <input type="hidden" name="csrf"
                                value="7c8e509e5a3d20b6fc90e179820f3c33e54a342c180b9135b52b63" />
                            <input type="hidden" name="categoryid" value="-1" id="categoryid" />
                            <input type="hidden" name="subcategoryid" value="" />
                            <input type="hidden" name="preloadedcategoryid" value="0" />
                            <input type="hidden" name="preloadedsubcategoryid" value="0" />
                            <input type="hidden" name="language" value="eng" />
                            <input type="hidden" name="reference" value="" />
                            <input type="hidden" name="t" value="" />
                            <input type="hidden" name="s" value="" />
                            <input type="hidden" name="eb" value="" />
                            <input type="hidden" name="ebs" value="" />
                            <input type="hidden" name="admin" value="-1" />








                            <table role="presentation" data-questiontype="1"
                                data-relatedvars="qh-color,ql-background-color,ql-capitalization,ql-font,ql-font-color,ql-font-size,qi-container-bg-color,qi-bg-color,qi-font-size"
                                class="questionContainer questionLabelLeft " cellspacing="0" cellpadding="2"
                                id="q214992506" style="">
                                <tr>
                                    <td width="175" align="right" valign="top" class="standard questionLabel">Email
                                        Address<font class="red" aria-hidden="true">*</font>
                                    </td>
                                    <td class="questionInput" valign="top" class="standard"><label for="email" style="position: absolute !important;clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
clip: rect(1px, 1px, 1px, 1px);">Email Address</label><input aria-required="true" class="shadow" id="email" type="text"
                                            name="input[email]" value="" style="width:350px;" />
                                    </td>
                                </tr>
                            </table>




                            <table role="presentation" cellspacing="0" cellpadding="2"
                                class="standard r-standard questionContainer">


                                <script type="text/javascript">
                                var applyCodeClicked = 0;
                                </script>
                                <tr class="discount-code-tr">
                                    <td width="175" align="right" valign="top" class="questionLabel ">
                                        Discount Code
                                    </td>
                                    <td class="questionInput">
                                        <label for="discountcode" class="hidden_label">discountcode</label>
                                        <input aria-describedby="discountcode_instructions" class="shadow "
                                            id="discountcode" type="text" name="discountcode" value="" size="30" />
                                        <input class="shadow" type="submit" role="button" name="apply_code"
                                            value="Apply Code"
                                            onclick="javascript:++applyCodeClicked; if(applyCodeClicked >1){ this.disabled = true; return false; }" />
                                        <br />
                                        <span id="discountcode_instructions"> (If you have been given a specific
                                            discount code please enter it here) </span>
                                    </td>
                                </tr>







                                <tr class="category-selection-tr">
                                    <td colspan="2">
                                        <br /><b><span id="showcategoryquestions"><bdi>Please select from the following
                                                    options:</bdi></span></b>
                                        <font aria-hidden="true" class="red">*</font><br /><br />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">

                                        <div aria-labelledby="showcategoryquestions" role="radiogroup"
                                            aria-required="true">
                                            <table role="presentation">
                                                <tr class="category-selection-tr" style="">
                                                    <td width="175" align="right" valign="top"><input type="radio"
                                                            id="c201756425" name="selectcategoryid" value="201756425"
                                                            onclick="altercost(15.00);closeallpass();"
                                                            onkeypress="altercost(15.00);closeallpass();" /></td>
                                                    <td class="optionclassiso"><label id="category_201756425"
                                                            for="c201756425">INSOL Member<span
                                                                class="displayInlineBlock">&nbsp;&pound;15.00&nbsp;</span><br />
                                                            <p>Members of <strong>INSOL India</strong></p>
                                                        </label> </td>
                                                </tr>
                                                <tr class="category-selection-tr" style="">
                                                    <td width="175" align="right" valign="top"><input type="radio"
                                                            id="c201756426" name="selectcategoryid" value="201756426"
                                                            onclick="altercost(30.00);closeallpass();"
                                                            onkeypress="altercost(30.00);closeallpass();" /></td>
                                                    <td class="optionclassiso"><label id="category_201756426"
                                                            for="c201756426">Non-Member<span
                                                                class="displayInlineBlock">&nbsp;&pound;30.00&nbsp;</span><br />
                                                            <p>Registrants who are not members of <strong>INSOL
                                                                    India</strong></p>

                                                            <p>(<em>To enquire about joining <strong>INSOL
                                                                        India</strong> please contact <a
                                                                        href="mailto:tony.ashton@insol.org">tony.ashton@insol.org</a></em>)
                                                            </p>
                                                        </label> </td>
                                                </tr>

                                            </table>
                                        </div>
                                    </td>
                                </tr>





                            </table>
                            <div id="totalcostsection" aria-live="polite" aria-atomic="true" tabindex="0">
                                <table cellspacing="0" cellpadding="2" width="100%">
                                    <tr id="totalcostdisplay" style="display:none;">
                                        <td colspan="2" align="center"><b id="totalcostdesc">Total Cost</b> &pound;<span
                                                id="totalcost">0.00</span></td>
                                    </tr>
                                </table>
                            </div>

                            <table cellspacing="0" cellpadding="2" width="100%"
                                data-relatedvars="rb-hover-color,rb-hover-border,rb-hover-font,rb-background-color,rb-border-radius,rb-font-color,rb-font-size,rb-font-weight,rb-border-color,rb-font"
                                id="buttontable">
                                <tr>
                                    <td colspan="2" align="center" id="button_continue_1">
                                        <br />
                                        <span id="addbackbtndiv"><input name="reg_button" type="button"
                                                class="button r-button" pid="back_enabled" value="Back" /></span>
                                        <input name="reg_button" type="submit" class="button r-button" onclick="if (this.classList.contains(&apos;clicked&apos;)){
                if(this.type == &apos;submit&apos; || this.type == &apos;image&apos;) {
                  this.form.setAttribute(&apos;onsubmit&apos;,&apos;return false&apos;);
                  this.disabled = true;
                } else{
                    return false;
                  }
              } else { this.classList.add(&apos;clicked&apos;); }" value="Continue" />
                                    </td>
                                </tr>
                            </table>




                        </form>
                        <link href="include/css/waitlist_message.css?_=e708a6589fb8afafb8f496c1a5624dba883b9988"
                            rel="stylesheet" type="text/css" />
                        <script type="text/javascript"
                            src="include/scripts/waitlist_message.js?_=e708a6589fb8afafb8f496c1a5624dba883b9988">
                        </script>

                        <script language="javascript">
                        function altercost(grandtotal) {
                            if (grandtotal > 0) {
                                document.getElementById('totalcostdisplay').style.display = '';
                            }
                            document.getElementById('totalcost').innerHTML = number_format(grandtotal, '2', '.', ',');
                        }

                        function closeallpass() {}

                        function warnCategoryOversold(e, categoryName) {
                            if (e.type == 'hidden' && categoryName == "" && e.value > 0) {
                                categoryName = document.getElementById('category_name').innerText;
                            } else if (e.type == 'hidden' && e.value <= 0) {
                                return false;
                            }

                            var msg = 'By submitting this form you will be overselling the category ' + categoryName +
                                '. \n Are you sure that you want to Continue?';
                            if (confirm(msg)) {
                                document.getElementById('skipCategory').value = 1;

                            } else {
                                if (e.type == 'radio') {
                                    e.checked = false;
                                    document.getElementById('skipCategory').value = 0;
                                }
                            }
                        }

                        function clearCategorySkip() {
                            document.getElementById('skipCategory').value = 0;
                        }
                        </script>

                        <script type='text/javascript'>
                        var questionsbasedoncat = [];
                        jQuery('[name=selectcategoryid]').on('click', function(e) {
                            var selectedcategory = jQuery(this).val();
                            jQuery.each(questionsbasedoncat, function(key, value) {
                                if (value[selectedcategory]) {
                                    if (jQuery('#q' + key).is('input'))
                                        jQuery('#q' + key).val(value[selectedcategory]);
                                    else
                                        jQuery('#' + key).val(value[selectedcategory]);
                                }
                            });
                        });
                        </script>


                        <!--[if lt IE 9]><script type="text/javascript">fixPhoneCountryCodesDropdowns();</script><![endif]-->
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="linkSnippetVersion needs-innerpagecolor" data-relatedvars="bottom-color" bgcolor="#ffffff">
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="poweredBy" width="120"><a target="_blank" href="http://www.etouches.com/"
                            class="powered-by-logo"><img src="/images/powered-by-aventri.png" border="0" width="144"
                                height="44" alt="Event management software by Aventri"
                                style="visibility: hidden;" /></a></td>
                    <td width="530" style="display:none">&nbsp</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr class="needs-table-color" bgcolor="#a1adb8">
        <td align="center" class="footerLinks"><a class="menu" target="_blank" href="http://">Event Home Page</a></td>
    </tr>
    </table>
    <div id="selectdescription"
        style="display:none;position:absolute;border:1px solid #000000;width:300px;background:#FFFFFF;padding:5px;">
    </div>
    <div id="overlay"
        style="position:absolute;display:none;opacity:.75;filter:alpha(opacity=75);z-index:90;top:0;left:0;background-color:#000000;">
    </div>
    <div class="r-mobile">
        <div id="loading" class="">
            <div id="loadingcontent" style="">
                <div id="loadingspinner" style="">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    jQuery(function() {

        jQuery('form').submit(function(e) {
            var f = e.target;
            if (!jQuery(this).data("prevent-default")) {
                e.preventDefault();
            }
            jQuery('#loading').fadeIn(
                function(e, target) {
                    f.submit();
                }
            );
        });

        // FIXES IPHONE ZOOMING IN ON FORM ELEMENTS
        jQuery("body.matchmaking input[type=text], body.matchmaking textarea, body.matchmaking select").on({
            'touchstart': function() {
                zoomDisable();
            }
        });
        jQuery("body.matchmaking input[type=text], body.matchmaking textarea, body.matchmaking select").on({
            'touchend': function() {
                setTimeout(zoomEnable, 500);
            }
        });

        function zoomDisable() {
            jQuery('head meta[name=viewport]').remove();
            jQuery('head').prepend(
                '<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />');
        }

        function zoomEnable() {
            jQuery('head meta[name=viewport]').remove();
            jQuery('head').prepend(
                '<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1" />');
        }
    });
    </script>
    <script type="text/javascript">
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        var clearFileInputField = function(container) {
            if (container) {
                container.innerHTML = container.innerHTML;
            }
            container.select('input:file').invoke('observe', 'change', handleOnFileChange);
        };
        var handleOnFileChange = function(evt) {
            var files = evt.target.files;
            if (!files) {
                return;
            }
            for (var i = 0; i < files.length; i++) {
                if (files[i] && files[i].size > 52428800) {
                    evt.preventDefault();
                    clearFileInputField(this.up('tr'));
                    alert('file too big');
                    return false;
                }
            }
        };

        $$('input:file').invoke('observe', 'change', handleOnFileChange);
    }
    </script>

    <script type="text/javascript" src="<?php echo SITE_ROOT; ?>ereg/include/pickadate/picker.js"></script>
    <script type="text/javascript" src="<?php echo SITE_ROOT; ?>ereg/include/pickadate/picker.date.js"></script>
    <script type="text/javascript" src="<?php echo SITE_ROOT; ?>ereg/include/pickadate/picker.time.js"></script>
    <script type="text/javascript" src="<?php echo SITE_ROOT; ?>ereg/include/pickadate/legacy.js"></script>



    <input type='hidden' name='backbuttonCategory' id='backbuttonCategory' value=''><input type='hidden'
        name='backbuttonResponsive' id='backbuttonResponsive' value='0'><input type='hidden' name='backbtnLink'
        id='backbtnLink' value='<?php echo SITE_ROOT; ?>ereg/index.php?eventid=200225862&t='><input type='hidden'
        name='backRegButtonVal' id='backRegButtonVal' value='Back'>
    <script type="text/javascript" src="<?php echo SITE_ROOT; ?>ereg/include/scripts/create_back_button.js"></script>
</body>

</html>