<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="alternate" type="application/atom+xml" title="News" href="/feed">
    <style>
        @font-face {
            font-family: 'Lato-Regular';
            src: url({{ asset('font/Lato-Regular.ttf') }});
        }

        @font-face {
            font-family: 'Lato-Semibold';
            src: url({{ asset('font/Lato-Semibold.ttf') }});
        }

        @font-face {
            font-family: 'Lato-Bold';
            src: url({{ asset('font/Lato-Bold.ttf') }});
        }

        * {
            margin: 0;
            padding: 0;
            user-select: none;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;

        }

        .sidebar {
            background: #212529;
            position: fixed;
            width: 120%;
            height: 100%;
            left: 0;
            overflow-y: auto;
            -ms-overflow-style: none;
            /* for Internet Explorer, Edge */
            scrollbar-width: none;
            /* for Firefox */
            overflow-y: scroll;
        }

        .sidebar .text {
            color: #ef2027;
            font-size: 25px;
            font-weight: 600;
            line-height: 65px;
            text-align: center;
            background: transparent;
            letter-spacing: 1px;
            margin-bottom: 0rem;
        }

        nav ul {
            /* background-image: linear-gradient(to bottom, #184d47, #133944, #1d2532, #19151b, #ef2027); */
            height: 100%;
            width: 100%;
            list-style: none;
        }

        nav ul li {
            line-height: 60px;
            /* border-bottom: 1px solid rgb(255, 255, 255); */
        }

        nav ul li:last-child {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05)
        }

        nav ul li a {
            position: relative;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            padding-left: 20px;
            font-weight: 500;
            display: block;
            width: auto;
            border-left: 3px solid transparent;
        }

        /* nav ul li.active a {
            color: cyan;
            background: #70cacc;
            border-left-color: cyan;
        } */

        nav ul li.active ul li a {
            color: #e6e6e6;
            background: #cc7070;
            border-left-color: transparent;
        }

        .sbitem11.active {
            color: #e6e6e6;
            background: #cc7070;
            border-left-color: transparent;
        }

        .sbitem12.active {
            color: #e6e6e6;
            background: #cc7070;
            border-left-color: transparent;
        }

        .sbitem13.active {
            color: #e6e6e6;
            background: #cc7070;
            border-left-color: transparent;
        }

        .sbitem14.active {
            color: #e6e6e6;
            background: #cc7070;
            border-left-color: transparent;
        }

        .sbitem21.active {
            color: #e6e6e6;
            background: #cc7070;
            border-left-color: transparent;
        }
        .sbitem22.active {
            color: #e6e6e6;
            background: #cc7070;
            border-left-color: transparent;
        }

        nav ul ul li a:hover {
            color: #9D865C !important;
            background: white !important;
        }

        nav ul ul {
            position: static;
            display: none;
        }

        nav ul .leads-show.show {
            display: block;
            height: 12rem;
            overflow-y: scroll;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #ffff;
        }
        nav ul .subscriptions-show.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #efefef;
        }

        nav ul .comments-show.show {
            display: block;
            height: 12rem;
            overflow-y: scroll;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #ef2027, 2px 0 5px -1px #0000000;
            background: #efefef;
        }

        nav ul .data-show.show {
            display: block;
            height: 12rem;
            overflow-y: scroll;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }

        nav ul .data-show2.show {
            display: block;
            height: auto;
            /* overflow-y: scroll; */
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }

        nav ul .data-show3.show {
            display: block;
            height: auto;
            /* overflow-y: scroll; */
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }

        nav ul .asd-show.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }

        nav ul .report-show.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }

        nav ul .au-show.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }

        nav ul .pm-show.show {
            display: block;
            height: 12rem;
            overflow-y: scroll;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }

        nav ul .pm-event.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }

        nav ul .ap-show.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }

        nav ul .meet-show.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }

        nav ul .setting-show.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }

        nav ul .sync-show.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }
        nav ul .data-show21.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }
        nav ul .off-plan-show30.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }
        nav ul .off-plan-show63.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }
        nav ul .off-plan-show56.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }

          nav ul .off-plan-show31.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }
        nav ul .off-plan-show32.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }
        nav ul .off-plan-show55.show {
            display: block;
            height: auto;
            overflow-y: auto;
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #fff;
        }
        nav ul ul li {
            line-height: 42px;
            border-bottom: none;
        }

        nav ul ul li a {
            font-size: 14px;
            color: #212529;
            padding-left: 25px;
        }

        #wrapper {
            height: inherit;
        }

        nav ul li a span {
            /* position: absolute;
    top: 10px;
    right: 14px;
    transform: translate(-50%); */
            font-size: 12px;
        }

        nav ul li a span.rotate {
            transform: translate(-50%) rotate(-180deg);
        }

        .selected {
            padding-left: 20px !important;
            border-left: 4px solid #9D865C;
            background: #8ca7d600;
            color: #ffff;
        }


        #sbitem1 .link-content,
        #sbitem2 .link-content,
        #sbitem3 .link-content,
        #sbitem4 .link-content,
        #sbitem5 .link-content,
        #sbitem6 .link-content,
        #sbitem7 .link-content,
        #sbitem8 .link-content,
        #sbitem12 .link-content,
        #sbitem13 .link-content,
        #sbitem14 .link-content,
        #sbitem15 .link-content,
        #sbitem22 .link-content,
        #sbitem16 .link-content,
        #sbitem17 .link-content,
        #sbitem20 .link-content,
        #sbitem21 .link-content,
        #sbitem55 .link-content,
        #sbitem31 .link-content,
        #sbitem32 .link-content,
        #sbitem30 .link-content,
        #sbitem56 .link-content,
        #sbitem63 .link-content
        {
            height: 4rem;
            padding: 9px 20px;
            align-items: center;
            display: flex;
        }

        /* .link-content span{
            position: absolute!important;
            top: 29px!important;
        } */
        .left-title {
            width: 90%;
            font-size: 16px;
            font-family: 'Lato-Semibold' !important;
        }

        .icon-title {
            width: 10%;
            text-align: right;
        }

        a:hover {
            color: #9D865C !important
        }

        .sidebar-brand-icon {
            width: 100%;
            display: flex;
            align-items: center;
            height: 4rem;
        }

        .user-name {
            width: 40%;
            font-size: 16px;
            font-family: 'Lato-Semibold' !important;
            color: #ffff;
            line-height: 1.2;
            padding-top: 0px;
        }

        .user-img {
            width: 75% !important;
            object-fit: contain;
            height: 4rem;
            margin: auto;
        }

        #sbitem1_6 a,
        #sbitem1_8 a,
        #sbitem1_9 a {
            font-size: 12px;
            font-family: 'Lato-Semibold' !important;
        }

        .show li.active a {
            color: #ffffff;
            background: #9D865C;
            border: 4px solid #fff;
            line-height: 1.5;
            padding: 7px 5px 7px 25px;
        }

        #wrapper {
            background: url({{ asset('img/bg0.png') }});
            background-size: cover;
            background-repeat: no-repeat;
            /* background-position: bottom; */
        }

        footer.sticky-footer {
            display: none;
        }

        @media (min-width: 1470px) {
            .sidebar {
                width: 17.5rem !important;
            }
        }

        @media(max-width:1280px) and (min-width:1201px) {
            /* .top-title{
                    margin-left: 7px!important;
            } */
        }

        @media(max-width:1200px) and (min-width:1100px) {
            .full-content {
                padding: 0 0 0 2.5rem !important;
            }

            #bg-top {
                margin-left: -4rem !important;
            }
        }

        @media(max-width:1024px) {
            .top-title {
                padding: 14px 16px !important;
                font-size: 16px;
            }

            .sidebar {
                width: 12rem !important;
            }

            .left-title {
                line-height: 1;
            }

            .user-name {
                line-height: 1.2;
                width: 90%;
            }

            #sbitem1 .link-content,
            #sbitem2 .link-content,
            #sbitem3 .link-content,
            #sbitem4 .link-content,
            #sbitem5 .link-content,
            #sbitem6 .link-content,
            #sbitem7 .link-content,
            #sbitem8 .link-content,
            #sbitem12 .link-content,
            #sbitem13 .link-content,
            #sbitem21 .link-content,
            #sbitem22 .link-content,
            #sbitem14 .link-content {
                padding: 9px 7px;
            }

            .left-title {
                font-size: 13px;
            }
        }

        @media(max-width:768px) {

            .sidebar {
                width: 9rem !important;
            }

            .sidebar .sidebar-brand {
                height: auto;
            }

            .sidebar-brand-icon {
                display: grid;
                justify-content: center;
                margin-top: 2rem;
            }
        }

        @media(max-width:500px) {

            /*sidebar mobile */
            .sidebar {
                width: 6.5rem !important;
            }

            .sidebar .sidebar-brand {
                height: auto;
            }

            .sidebar-brand-icon {
                display: grid;
                justify-content: center;
            }

            .user-name {
                width: 100%;
            }

            nav ul li {
                line-height: 7px !important;
            }

            nav ul .pm-show.show {
                height: 10rem;
            }

            nav ul .ap-show.show {
                height: auto;
            }

            nav ul .asd-show.show {
                height: auto;
                overflow-y: auto;
                overflow-x: hidden;
            }

            nav ul .au-show.show {
                height: auto;
            }

            #sbitem1 .link-content,
            #sbitem2 .link-content,
            #sbitem3 .link-content,
            #sbitem4 .link-content,
            #sbitem5 .link-content,
            #sbitem6 .link-content,
            #sbitem7 .link-content,
            #sbitem8 .link-content,
            #sbitem12 .link-content,
            #sbitem13 .link-content,
            #sbitem21 .link-content,
            #sbitem22 .link-content,
            #sbitem14 .link-content {
                height: 4rem;
                padding: 9px 6px;
            }

            .left-title {
                width: 90%;
                font-size: 12px;
                line-height: 1;
            }

            .icon-title {
                font-size: 10px !important;
            }

            #sbitem1_1,
            #sbitem1_2,
            #sbitem1_3,
            #sbitem1_4,
            #sbitem1_5,
            #sbitem1_6,
            #sbitem1_7,
            #sbitem1_8,
            #sbitem1_9 {
                line-height: 17px !important;
                margin-bottom: 10px;
            }

            #sbitem1_1 a,
            #sbitem1_2 a,
            #sbitem1_3 a,
            #sbitem1_4 a,
            #sbitem1_5 a,
            #sbitem1_6 a,
            #sbitem1_7 a,
            #sbitem1_8 a,
            #sbitem1_9 a {
                padding-left: 15px !important;
                font-size: 12px !important;
            }

            #sbitem2_1,
            #sbitem2_2,
            #sbitem2_3,
            #sbitem2_4,
            #sbitem2_4_1,
            #sbitem2_5,
            #sbitem2_6,
            #sbitem2_7,
            #sbitem2_7_1,
            #sbitem2_8,
            #sbitem2_9,
            #sbitem2_10,
            #sbitem2_11 {
                line-height: 17px !important;
                margin-bottom: 10px !important;
            }

            #sbitem2_1 a,
            #sbitem2_2 a,
            #sbitem2_3 a,
            #sbitem2_4 a,
            #sbitem2_4_1 a,
            #sbitem2_5 a,
            #sbitem2_6 a,
            #sbitem2_7 a,
            #sbitem2_7_1 a,
            #sbitem2_8 a,
            #sbitem2_9 a,
            #sbitem2_10 a,
            #sbitem2_11 a {
                padding-left: 15px !important;
                font-size: 12px !important;
            }

            #sbitem3_1,
            #sbitem3_2,
            #sbitem3_3,
            #sbitem3_4,
            #sbitem3_5,
            #sbitem3_6 {
                line-height: 17px !important;
                margin-bottom: 10px !important;
            }

            #sbitem3_1 a,
            #sbitem3_2 a,
            #sbitem3_3 a,
            #sbitem3_4 a,
            #sbitem3_5 a,
            #sbitem3_6 a {
                padding-left: 15px !important;
                font-size: 12px !important;
            }

            #sbitem5_1,
            #sbitem5_2,
            #sbitem5_3,
            #sbitem5_4,
            #sbitem5_5,
            #sbitem5_6,
            #sbitem5_7,
            #sbitem5_8,
            #sbitem5_9,
            #sbitem5_10,
            #sbitem5_11,
            #sbitem5_12 {
                line-height: 17px !important;
                margin-bottom: 10px !important;
            }

            #sbitem7_1,
            #sbitem7_2 {
                line-height: 17px !important;
                margin-bottom: 10px !important;
            }

            #sbitem8_1,
            #sbitem8_2,
            #sbitem8_3,
            #sbitem8_4 {
                line-height: 17px !important;
                margin-bottom: 10px !important;
            }

            #sbitem5_1 a,
            #sbitem5_2 a,
            #sbitem5_3 a,
            #sbitem5_4 a,
            #sbitem5_5 a,
            #sbitem5_6 a,
            #sbitem5_7 a,
            #sbitem5_8 a,
            #sbitem5_9 a,
            #sbitem5_10 a,
            #sbitem5_11 a,
            #sbitem5_12 a {
                padding-left: 15px !important;
                font-size: 12px !important;
            }

            #sbitem7_1 a,
            #sbitem7_2 a,
            {
            padding-left: 15px !important;
            font-size: 12px !important;
        }

        #sbitem8_1 a,
        #sbitem8_2 a,
        #sbitem8_3 a,
        #sbitem8_4 a,
        {
        padding-left: 15px !important;
        font-size: 12px !important;
        }


        #sbitem12_1,
        #sbitem12_2 {
            line-height: 17px !important;
            margin-bottom: 10px !important;
        }

        #sbitem12_1 a,
        #sbitem12_2 a {
            padding-left: 15px !important;
            font-size: 12px !important;
        }

        #sbitem14_1,
        #sbitem14_2,
        #sbitem14_3,
        #sbitem14_4 {
            line-height: 17px !important;
            margin-bottom: 10px !important;
        }

        #sbitem14_1 a,
        #sbitem14_2 a,
        #sbitem14_3 a,
        #sbitem14_4 a {
            padding-left: 15px !important;
            font-size: 12px !important;
        }

        #sbitem4_1,
        #sbitem4_2,
        #sbitem4_3,
        #sbitem4_4,
        #sbitem4_5,
        #sbitem4_88,
        #sbitem4_6,
        #sbitem4_7 {
            line-height: 17px !important;
            margin-bottom: 10px !important;
        }

        #sbitem4_1 a,
        #sbitem4_2 a,
        #sbitem4_3 a,
        #sbitem4_4 a,
        #sbitem4_5 a,
        #sbitem4_6 a,
        #sbitem4_88 a,
        #sbitem4_7 a {
            padding-left: 15px !important;
            font-size: 12px !important;
        }

        .sidebar .sidebar-brand {
            height: 8.375rem !important;
        }

        .pagination li .page-link {
            font-size: 10px !important;
            padding: 0.5rem 0.15rem !important;
        }

        .page-item.disabled .page-link {
            text-align: center !important;
        }

        .justify-content-end {
            justify-content: center !important;
        }

        .user-img {
            width: 100% !important;
        }

        }

        @media (max-width: 768px) {
            .sidebar {
                width: 9rem !important;
            }

            #sbitem1_1 a,
            #sbitem1_2 a,
            #sbitem1_3 a,
            #sbitem1_4 a,
            #sbitem1_5 a,
            #sbitem1_6 a,
            #sbitem1_7 a,
            #sbitem1_8 a,
            #sbitem1_9 a {
                line-height: 2;
            }

            #sbitem2_1 a,
            #sbitem2_2 a,
            #sbitem2_3 a,
            #sbitem2_4 a,
            #sbitem2_5 a,
            #sbitem2_6 a,
            #sbitem2_7 a,
            #sbitem2_8 a,
            #sbitem2_9 a,
            #sbitem2_10 a,
            #sbitem2_11 a,
            #sbitem2_12 a,
            {
            line-height: 2;
            padding-left: 13px;
            font-size: 12px;
        }

        .asd-show li a {
            line-height: 2;
            padding-left: 13px;
            font-size: 12px;
        }

        nav ul .asd-show.show {
            height: auto;
        }

        .report-show li a {
            line-height: 2;
            padding-left: 13px;
            font-size: 12px;
        }

        nav ul .pm-show.show {
            height: 10rem;
        }

        nav ul .ap-show.show {
            height: auto;
        }

        .pm-show li a {
            line-height: 2;
            padding-left: 13px;
            font-size: 12px;
        }

        .pm-event li a {
            line-height: 2;
            padding-left: 13px;
            font-size: 12px;
        }

        .au-show li a {
            line-height: 2;
            padding-left: 13px;
            font-size: 12px;
        }

        .selected {
            padding-left: 15px !important;
        }

        .sidebar .sidebar-brand,
        .sidebar-brand-icon,
        .user-img {
            height: auto !important;
        }

        .user-img {
            width: 100% !important;
        }

        .sidebar .sidebar-brand {
            padding: 0rem 1rem;
        }
        }

        @media (max-width: 500px) {
            .sidebar {
                width: 6.5rem !important;
            }

            .selected {
                padding-left: 8px !important;

            }

            .sidebar .sidebar-brand {
                padding: 5px !important;
            }

            .sidebar-brand-icon {
                margin-top: 0 !important;
            }
        }

        label {
            color: #211706 !important;
        }

        li#tab-dashboard {
            background: #ffffff;
            text-align: center;
        }

        li#tab-dashboard a.home-link {
            padding-left: 0px !important;
            color: #ef2027 !important;
            border: 8px solid #ef2027;
            font-size: 20px !important;
        }

        li#tab-dashboard a.home-link:hover {
            padding-left: 0px !important;
            color: #504d4d !important;
            border: 8px solid #ef2027 !important;
            font-size: 20px !important;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #ef2027;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            padding: 10px;
            font-size: 16px;
            z-index: 100;
            width: 100%;
            top: 7%;
            color: #fff;
            height: 200px;
            overflow-y: scroll;

        }

        #bell {
            /* font-size: 30px; */
            margin: 15px;
            display: inline;
            position: absolute;
            left: 0;
            cursor: pointer;
        }

        .dropdown-content-length {
            position: absolute;
            top: -2%;
            font-size: 20px;
            left: 30px;
            z-index: 1;
            color: #fff;


        }

        .drow {
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .option {
            cursor: default;
            background-color: #ef2027;
            pointer-events: none;
        }



        nav.sidebar::-webkit-scrollbar {
            width: 3px !important;

        }

        /* Track */
        nav.sidebar::-webkit-scrollbar-track {
            background: #9D865C !important;
        }

        /* Handle */
        nav.sidebar::-webkit-scrollbar-thumb {
            background: #9D865C;
            border-radius: 0px;
            border-radius: 8px;
        }

        /* Handle on hover */
        nav.sidebar::-webkit-scrollbar-thumb:hover {
            background: #161616;
            border-radius: 8px;
        }


        ul.show::-webkit-scrollbar {
            width: 5px !important;

        }

        /* Track */
        ul.show::-webkit-scrollbar-track {
            background: #9e9ea1d9 !important;
        }

        /* Handle */
        ul.show::-webkit-scrollbar-thumb {
            background: #131212;
            border-radius: 0px;
            border-radius: 8px;
        }

        /* Handle on hover */
        ul.show::-webkit-scrollbar-thumb:hover {
            background: #003ea59;
            border-radius: 8px;
        }

        .option {
            cursor: default;
            background-color: #ef2027;
            pointer-events: none;
        }

        nav ul .data-show20.show {
            display: block;
            height: auto;
            /* overflow-y: scroll; */
            width: 100%;
            border-radius: 0px 3px 3px 0;
            box-shadow: 0px -3px 3px -1px #656161, 2px 0 5px -1px #fff;
            background: #efefef;
        }
    </style>

    @stack('head')

</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div style="width: 20%; height: 100%;">
            @include('layouts.sidebar')
        </div>

        <div style="width: 80%;">
            @yield('wrapper_content')
        </div>

    </div>

    @yield('content')

    @stack('scripts')

    <script>
        $(window).on('load', function() {
            if (
                "{{ request()->route()->getName() }}" == 'follow_up_user_home_index' ||
                "{{ request()->route()->getName() }}" == 'leads_pool_user_home_index' ||
                "{{ request()->route()->getName() }}" == 'qualified_user_home_index' ||
                "{{ request()->route()->getName() }}" == 'proceeded_user_home_index' ||
                "{{ request()->route()->getName() }}" == 'leads_pool_index' ||
                "{{ request()->route()->getName() }}" == 'won_leads_index' ||
                "{{ request()->route()->getName() }}" == 'dead_leads_index' ||
                "{{ request()->route()->getName() }}" == 'follow_up_index' ||
                // "{{ request()->route()->getName() }}" == 'create_customer_index' ||
                "{{ request()->route()->getName() }}" == 'qualified_leads_index' ||
                "{{ request()->route()->getName() }}" == 'agent_data' ||
                "{{ request()->route()->getName() }}" == 'map' ||
                "{{ request()->route()->getName() }}" == 'agent_data' ||
                "{{ request()->route()->getName() }}" == 'createlead' ||
                "{{ request()->route()->getName() }}" == 'proceeded_leads_index' ||
                "{{ request()->route()->getName() }}" == 'import_index'
            ) {
                $('#sbitem1').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'leads_pool_index')
                    $('#sbitem1_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'won_leads_index')
                    $('#sbitem1_2').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'dead_leads_index')
                    $('#sbitem1_3').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'qualified_leads_index')
                    $('#sbitem1_4').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'follow_up_index')
                    $('#sbitem1_5').addClass('active');
                // else if ("{{ request()->route()->getName() }}" == 'create_customer_index')
                //     $('#sbitem1_6').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'agent_data')
                    $('#sbitem1_8').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'map')
                    $('#sbitem1_9').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'qualified_user_home_index')
                    $('#sbitem1_10').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'leads_pool_user_home_index')
                    $('#sbitem1_12').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'follow_up_user_home_index')
                    $('#sbitem1_14').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'createlead')
                    $('#sbitem1_16').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'proceeded_user_home_index')
                    $('#sbitem1_17_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'proceeded_leads_index')
                    $('#sbitem1_19').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'import_index')
                    $('#sbitem1_17').addClass('active');

                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .leads-show').toggleClass('show');
                $('nav ul .first').toggleClass('rotate');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan56').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');
                $('nav ul .off-plan-show56').removeClass('show');
            } else if (
                "{{ request()->route()->getName() }}" == 'assign_agent_data_index' ||
                // "{{ request()->route()->getName() }}" == 'assign_agent_qualified_data_index' ||
                "{{ request()->route()->getName() }}" == 'assign_agent_leads_pool_index' ||
                // "{{ request()->route()->getName() }}" == 'assign_agent_follow_up_index' ||
                // "{{ request()->route()->getName() }}" == 'show_assigned_agent_qualified_index' ||
                // "{{ request()->route()->getName() }}" == 'show_assigned_agent_follow_up_index' ||
                "{{ request()->route()->getName() }}" == 'show_user_qualified_data_comments_index' ||
                "{{ request()->route()->getName() }}" == 'show_user_leads_pool_data_comments_index' ||
                "{{ request()->route()->getName() }}" == 'show_commented_data' ||
                "{{ request()->route()->getName() }}" == 'show_user_follow_up_data_comments_index' ||
                "{{ request()->route()->getName() }}" == 'show_user_proceeded_data_comments_index' ||
                "{{ request()->route()->getName() }}" == 'assign_agent_for_landing'
            ) {
                $('#sbitem2').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'assign_agent_data_index')
                    $('#sbitem2_1').addClass('active');
                // else if ("{{ request()->route()->getName() }}" == 'assign_agent_qualified_data_index')
                //     $('#sbitem2_2').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'assign_agent_leads_pool_index')
                    $('#sbitem2_3').addClass('active');
                // else if ("{{ request()->route()->getName() }}" == 'assign_agent_follow_up_index')
                //     $('#sbitem2_4').addClass('active');
                // else if ("{{ request()->route()->getName() }}" == 'show_assigned_agent_qualified_index')
                //     $('#sbitem2_5').addClass('active');
                // else if ("{{ request()->route()->getName() }}" == 'show_assigned_agent_follow_up_index')
                //     $('#sbitem2_7').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_commented_data')
                    $('#sbitem2_7_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_user_qualified_data_comments_index')
                    $('#sbitem2_9').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_user_leads_pool_data_comments_index')
                    $('#sbitem2_10').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_user_follow_up_data_comments_index')
                    $('#sbitem2_11').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_user_proceeded_data_comments_index')
                    $('#sbitem2_12').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'assign_agent_for_landing')
                    $('#sbitem4_2').addClass('active');




                $('nav ul .asd-show').toggleClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .second').toggleClass('rotate');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan56').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');
                $('nav ul .off-plan-show56').removeClass('show');

                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .data-show').removeClass('show');
                // $('nav ul .report-show').removeClass('show');
                // $('nav ul .pm-event').removeClass('show');
                // $('nav ul .au-show').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .asd-show').toggleClass('show');
                // $('nav ul .second').toggleClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'getcharts' ||
                "{{ request()->route()->getName() }}" == 'geochart' ||

                "{{ request()->route()->getName() }}" == 'leader_board_index' ||
                "{{ request()->route()->getName() }}" == 'officetime' ||
                "{{ request()->route()->getName() }}" == 'Success' ||
                "{{ request()->route()->getName() }}" == 'reportassignedagentsleads'
            ) {
                $('#sbitem3').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'getcharts')
                    $('#sbitem3_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'geochart')
                    $('#sbitem3_2').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'leader_board_index')
                    $('#sbitem3_5').addClass('active');

                else if ("{{ request()->route()->getName() }}" == 'officetime')
                    $('#sbitem3_8').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'Success')
                    $('#sbitem3_9').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'reportassignedagentsleads')
                    $('#sbitem3_10').addClass('active');


                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').toggleClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .third').toggleClass('rotate');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');

                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .asd-show').removeClass('show');
                // $('nav ul .data-show').removeClass('show');
                // $('nav ul .pm-event').removeClass('show');
                // $('nav ul .au-show').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .report-show').toggleClass('show');
                // $('nav ul .third').toggleClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'create_user_index' ||
                "{{ request()->route()->getName() }}" == 'assign_agent_data_index' ||
                "{{ request()->route()->getName() }}" == 'list_users_index' ||
                "{{ request()->route()->getName() }}" == 'uploadedFiles' ||
                "{{ request()->route()->getName() }}" == 'create_user_index' ||
                "{{ request()->route()->getName() }}" == 'update_user_index' ||
                "{{ request()->route()->getName() }}" == 'create_buyer_index' ||
                "{{ request()->route()->getName() }}" == 'create_super_Admin' ||
                "{{ request()->route()->getName() }}" == 'signature.index'


            ) {

                $('#sbitem4').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'create_buyer_index')
                    $('#sbitem4_1_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'create_user_index')
                    $('#sbitem4_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'list_users_index')
                    $('#sbitem4_3').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'uploadedFiles')
                    $('#sbitem4_5').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'create_super_Admin')
                    $('#sbitem4_6').addClass('active')
                else if ("{{ request()->route()->getName() }}" == 'signature.index'){
                    $('#sbitem4_88').addClass('active')
                }






                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').toggleClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .fourth').toggleClass('rotate');
                $('nav ul .subscriptions-show').removeClass('show');

                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');
                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .asd-show').removeClass('show');
                // $('nav ul .data-show').removeClass('show');
                // $('nav ul .report-show').removeClass('show');
                // $('nav ul .pm-event').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .au-show').toggleClass('show');
                // $('nav ul .fourth').toggleClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'show_leads_pool_data_comments_index' ||
                "{{ request()->route()->getName() }}" == 'show_follow_up_data_comments_index' ||
                "{{ request()->route()->getName() }}" == 'show_qualified_data_comments_index' ||
                "{{ request()->route()->getName() }}" == 'show_proceeded_data_comments_index' ||
                "{{ request()->route()->getName() }}" == 'index1'
            ) {
                $('#sbitem17').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'show_leads_pool_data_comments_index')
                    $('#sbitem17_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_follow_up_data_comments_index')
                    $('#sbitem17_2').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_qualified_data_comments_index')
                    $('#sbitem17_3').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_proceeded_data_comments_index')
                    $('#sbitem17_4').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'index1')
                    $('#sbitem17_5').addClass('active');




                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').toggleClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .twelve').toggleClass('rotate');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');

                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .asd-show').removeClass('show');
                // $('nav ul .data-show').removeClass('show');
                // $('nav ul .report-show').removeClass('show');
                // $('nav ul .pm-event').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .data-show2').toggleClass('show');
                // $('nav ul .comments-show').toggleClass('show');
                // $('nav ul .twelve').toggleClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'create_property_index' ||
                "{{ request()->route()->getName() }}" == 'create_payment_index' ||
                "{{ request()->route()->getName() }}" == 'list_properties_index' ||
                "{{ request()->route()->getName() }}" == 'list_payments_index' ||
                "{{ request()->route()->getName() }}" == 'create_inventory_index' ||
                "{{ request()->route()->getName() }}" == 'get_inventories_index' ||
                "{{ request()->route()->getName() }}" == 'create_new_community' ||
                "{{ request()->route()->getName() }}" == 'list_communities' ||
                "{{ request()->route()->getName() }}" == 'create_new_subcommunity' ||
                "{{ request()->route()->getName() }}" == 'list_subcommunities' ||
                "{{ request()->route()->getName() }}" == 'list_countries'||
                "{{ request()->route()->getName() }}" == 'list_cities'||
                "{{ request()->route()->getName() }}" == 'list_archived_properties_index'
            ) {
                $('#sbitem5').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'create_property_index')
                    $('#sbitem5_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'create_payment_index')
                    $('#sbitem5_2').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'list_properties_index')
                    $('#sbitem5_3').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'list_payments_index')
                    $('#sbitem5_4').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'create_inventory_index')
                    $('#sbitem5_5').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'get_inventories_index')
                    $('#sbitem5_6').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'create_new_community')
                    $('#sbitem5_8').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'list_communities')
                    $('#sbitem5_9').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'create_new_subcommunity')
                    $('#sbitem5_10').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'list_subcommunities')
                    $('#sbitem5_11').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'list_archived_properties_index')
                    $('#sbitem5_12').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'list_countries')
                    $('#sbitem5_14').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'list_cities')
                    $('#sbitem5_13').addClass('active');




                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').toggleClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .fifth').toggleClass('rotate');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');

                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .asd-show').removeClass('show');
                // $('nav ul .data-show').removeClass('show');
                // $('nav ul .report-show').removeClass('show');
                // $('nav ul .au-show').removeClass('show');
                // $('nav ul .pm-event').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .pm-show').toggleClass('show');
                // $('nav ul .fifth').toggleClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'create_appointment_index' ||
                "{{ request()->route()->getName() }}" == 'show_appointment_index'
            ) {
                $('#sbitem6').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'create_appointment_index')
                    $('#sbitem6_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_appointment_index')
                    $('#sbitem6_2').addClass('active');




                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').toggleClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .sixth').toggleClass('rotate');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');


                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .asd-show').removeClass('show');
                // $('nav ul .data-show').removeClass('show');
                // $('nav ul .report-show').removeClass('show');
                // $('nav ul .au-show').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .ap-show').toggleClass('show');
                // $('nav ul .sixth').toggleClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'create.meeting' ||
                "{{ request()->route()->getName() }}" == 'list.meetings'
            ) {
                $('#sbitem12').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'create.meeting')
                    $('#sbitem12_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'list.meetings')
                    $('#sbitem12_2').addClass('active');


                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').toggleClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .nine').toggleClass('rotate');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');

                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .asd-show').removeClass('show');
                // $('nav ul .data-show').removeClass('show');
                // $('nav ul .report-show').removeClass('show');
                // $('nav ul .au-show').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .ap-show').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .meet-show').toggleClass('show');
                // $('nav ul .nine').toggleClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'create.meeting' ||
                "{{ request()->route()->getName() }}" == 'list.meetings'
            ) {
                $('#sbitem13').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'setting.logo')
                    $('#sbitem13_1').addClass('active');



                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').toggleClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .ten').toggleClass('rotate');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');


                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .asd-show').removeClass('show');
                // $('nav ul .data-show').removeClass('show');
                // $('nav ul .report-show').removeClass('show');
                // $('nav ul .au-show').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .ap-show').removeClass('show');
                // $('nav ul .meet-show').removeClass('show');
                // $('nav ul .setting-show').toggleClass('show');
                // $('nav ul .ten').toggleClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'sync' ||
                "{{ request()->route()->getName() }}" == 'sync_communities' ||
                "{{ request()->route()->getName() }}" == 'sync_sub_communities' ||
                "{{ request()->route()->getName() }}" == 'sync_buildings'

            ) {
                $('#sbitem14').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'sync')
                    $('#sbitem14_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'sync_communities')
                    $('#sbitem14_2').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'sync_sub_communities')
                    $('#sbitem14_3').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'sync_buildings')
                    $('#sbitem14_4').addClass('active');


                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .sync-show').toggleClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .fourteen').toggleClass('rotate');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');
            } else if (
                "{{ request()->route()->getName() }}" == 'create_event' ||
                "{{ request()->route()->getName() }}" == 'list_event'
            ) {
                $('#sbitem7').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'create_event')
                    $('#sbitem7_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'create_payment_index')
                    $('#sbitem7_2').addClass('active');



                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').toggleClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .pm-events').toggleClass('rotate');

                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .asd-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                // $('nav ul .au-show').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .pm-event').toggleClass('show');
                // $('nav ul .pm-events').toggleClass('rotate');

            } else if (
                "{{ request()->route()->getName() }}" == 'home' ||
                "{{ request()->route()->getName() }}" == 'get_assigned_data_index' ||
                "{{ request()->route()->getName() }}" == 'show_assigned_agent_leads_pool_index' ||
                "{{ request()->route()->getName() }}" == 'show_comments_admin_index'
            ) {
                $('#sbitem8').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'home')
                    $('#sbitem8_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'get_assigned_data_index')
                    $('#sbitem8_2').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_assigned_agent_leads_pool_index')
                    $('#sbitem8_3').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'show_comments_admin_index')
                    $('#sbitem8_4').addClass('active');





                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').toggleClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .eight').toggleClass('rotate');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');


                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .asd-show').removeClass('show');
                // $('nav ul .report-show').removeClass('show');
                // $('nav ul .au-show').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .pm-event').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .data-show').toggleClass('show');
                // $('nav ul .eight').toggleClass('rotate');

            } else if (
                "{{ request()->route()->getName() }}" == 'create_blog' ||
                "{{ request()->route()->getName() }}" == 'listblogindex'

            ) {
                $('#sbitem15').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'create_blog')
                    $('#sbitem15_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'listblogindex')
                    $('#sbitem15_2').addClass('active');



                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').toggleClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .five-five').toggleClass('rotate');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');

                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .asd-show').removeClass('show');
                // $('nav ul .data-show').removeClass('show');
                // $('nav ul .report-show').removeClass('show');
                // $('nav ul .pm-event').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .data-show2').toggleClass('show');
                // $('nav ul .data-show3').toggleClass('show');
                // $('nav ul .five-five').toggleClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'create_developer' ||
                "{{ request()->route()->getName() }}" == 'listdeveloperindex'

            ) {
                $('#sbitem20').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'create_developer')
                    $('#sbitem20_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'listdeveloperindex')
                    $('#sbitem20_2').addClass('active');





                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').toggleClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .twenty').toggleClass('rotate');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');

                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .asd-show').removeClass('show');
                // $('nav ul .data-show').removeClass('show');
                // $('nav ul .report-show').removeClass('show');
                // $('nav ul .pm-event').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .data-show20').toggleClass('show');
                // $('nav ul .data-show3').toggleClass('show');
                // $('nav ul .twenty').toggleClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'create_building' ||
                "{{ request()->route()->getName() }}" == 'listbuildingindex'

            ) {
                $('#sbitem20').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'create_building')
                    $('#sbitem16_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'listbuildingindex')
                    $('#sbitem16_2').addClass('active');


                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').toggleClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .building').toggleClass('rotate');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');

                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .asd-show').removeClass('show');
                // $('nav ul .data-show').removeClass('show');
                // $('nav ul .report-show').removeClass('show');
                // $('nav ul .pm-event').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .data-show3').toggleClass('show');
                // $('nav ul .data-show3').toggleClass('show');
                // $('nav ul .building').toggleClass('rotate');
            }
            else if (
                "{{ request()->route()->getName() }}" == 'contact_us_list'

            )
            {
                $('#sbitem21').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'contact_us_list')
                    $('#sbitem21_1').addClass('active');
;


                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .contact_us21').toggleClass('rotate');
                $('nav ul .data-show21').toggleClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');


                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .asd-show').removeClass('show');
                // $('nav ul .data-show').removeClass('show');
                // $('nav ul .report-show').removeClass('show');
                // $('nav ul .pm-event').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .data-show3').toggleClass('show');
                // $('nav ul .data-show3').toggleClass('show');
                // $('nav ul .building').toggleClass('rotate');
            } else if (
                "{{ request()->route()->getName() }}" == 'subscriptions'
            ) {
                $('#sbitem22').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'subscriptions')
                    $('#sbitem22_1').addClass('active');

                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .subscriptions-span').toggleClass('rotate');
                $('nav ul .subscriptions-show').toggleClass('show');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .off-plan30').removeClass('rotate');
                $('nav ul .off-plan-show30').removeClass('show');



                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .asd-show').removeClass('show');
                // $('nav ul .data-show').removeClass('show');
                // $('nav ul .report-show').removeClass('show');
                // $('nav ul .au-show').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .ap-show').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .meet-show').toggleClass('show');
                // $('nav ul .nine').toggleClass('rotate');
            }
            else if (
                "{{ request()->route()->getName() }}" == 'create_developer' ||
                "{{ request()->route()->getName() }}" == 'listdeveloperindex'

            ) {
                $('#sbitem20').find('a:first').toggleClass('selected');
                if ("{{ request()->route()->getName() }}" == 'create_developer')
                    $('#sbitem20_1').addClass('active');
                else if ("{{ request()->route()->getName() }}" == 'listdeveloperindex')
                    $('#sbitem20_2').addClass('active');





                $('nav ul .asd-show').removeClass('show');
                $('nav ul .comments-show').removeClass('show');
                $('nav ul .data-show').removeClass('show');
                $('nav ul .data-show3').removeClass('show');
                $('nav ul .data-show20').removeClass('show');
                $('nav ul .data-show2').removeClass('show');
                $('nav ul .report-show').removeClass('show');
                $('nav ul .au-show').removeClass('show');
                $('nav ul .pm-event').removeClass('show');
                $('nav ul .pm-show').removeClass('show');
                $('nav ul .ap-show').removeClass('show');
                $('nav ul .meet-show').removeClass('show');
                $('nav ul .setting-show').removeClass('show');
                $('nav ul .sync-show').removeClass('show');
                $('nav ul .leads-show').removeClass('show');
                $('nav ul .twenty').removeClass('rotate');
                $('nav ul .contact_us21').removeClass('rotate');
                $('nav ul .data-show21').removeClass('show');
                $('nav ul .subscriptions-show').removeClass('show');
                $('nav ul .off-plan30').toggleClass('rotate');
                $('nav ul .off-plan-show30').toggleClass('show');

                // $('nav ul .leads-show').removeClass('show');
                // $('nav ul .asd-show').removeClass('show');
                // $('nav ul .data-show').removeClass('show');
                // $('nav ul .report-show').removeClass('show');
                // $('nav ul .pm-event').removeClass('show');
                // $('nav ul .pm-show').removeClass('show');
                // $('nav ul .setting-show').removeClass('show');
                // $('nav ul .data-show20').toggleClass('show');
                // $('nav ul .data-show3').toggleClass('show');
                // $('nav ul .twenty').toggleClass('rotate');
            }

            // else if (
            //     "{{ request()->route()->getName() }}" == 'get_calender' ||
            // ){
            //     $('#sbitem11').addClass('active');
            // }
        })
    </script>
    <script>
        $(window).on('load', function() {
            var count = 0;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('show_appoentmentdate_today') }}",
                success: function(result) {
                    $.each(result.appointments_today, function(key, value) {
                        if (value.show == "0") {
                            count += 1
                            $('.dropdown-content').append(
                                '<div class="dropdowncontent' + value.id +
                                ' drow" onclick="content(' + value.id + ')">' +
                                '<p style="font-size:12px">' + value.comment + '</p>' +
                                '<p style="font-size:10px">' + value.appointments + '</p>' +
                                '<p style="font-size:10px">' + value.stage + '</p>' +
                                '<hr>' +
                                '</div>'
                            );
                        } else {
                            $('.dropdown-content').append(
                                '<div class="dropdowncontent' + value.id +
                                ' drow option">' +
                                '<p style="font-size:12px">' + value.comment + '</p>' +
                                '<p style="font-size:10px">' + value.appointments + '</p>' +
                                '<p style="font-size:10px">' + value.stage + '</p>' +
                                '<hr>' +
                                '</div>'
                            );
                        }
                    });
                    if (count == '0') {
                        $('.dropdown-content-length').empty();
                    } else {
                        $('.dropdown-content-length').append(count);
                    }
                },
            });
        });
        $('#bell').click(function() {
            if ($('.dropdown-content').css('display') == 'block') {
                $('.dropdown-content').css('display', 'none');
            } else {
                $('.dropdown-content').css('display', 'block');
            }
        });

        function content(id) {
            var count = $('.dropdown-content-length').text();
            var count_de = count - 1;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: 'post',
                url: "{{ route('changeappoentmentdateshow') }}",
                data: {
                    id: id
                },
                success: function(result) {
                    $('.dropdown-content-length').empty();
                    if (count_de != 0)
                        $('.dropdown-content-length').append(count_de);
                    else
                        $('.dropdown-content-length').empty();
                    $('.dropdowncontent' + id).addClass('option');
                },
            });
        }
    </script>

    <script>
        $('.leads-btn').click(function() {

            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').toggleClass('show');
            $('nav ul .first').toggleClass('rotate');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .contact_us21').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan30').removeClass('rotate');
            $('nav ul .off-plan-show30').removeClass('show');


            // $('nav ul .leads-show').toggleClass('show');
            // $('nav ul .asd-show').removeClass('show');
            // $('nav ul .report-show').removeClass('show');
            // $('nav ul .au-show').removeClass('show');
            // $('nav ul .pm-show').removeClass('show');
            // $('nav ul .first').removeClass('rotate');
            // $('nav ul .pm-event').removeClass('show');
            // $('nav ul .meet-event').removeClass('show');
            // $('nav ul .setting-show').removeClass('show');
            // $('nav ul .comments-show').removeClass('show');
        });
        $('.asd-btn').click(function() {


            $('nav ul .asd-show').toggleClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .second').toggleClass('rotate');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .contact_us21').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan30').removeClass('rotate');
            $('nav ul .off-plan-show30').removeClass('show');

            // $('nav ul .leads-show').removeClass('show');
            // $('nav ul .asd-show').toggleClass('show');
            // $('nav ul .pm-event').removeClass('show');
            // $('nav ul .report-show').removeClass('show');
            // $('nav ul .au-show').removeClass('show');
            // $('nav ul .pm-show').removeClass('show');
            // $('nav ul .second').toggleClass('rotate');
            // $('nav ul .meet-event').removeClass('show');
            // $('nav ul .setting-show').removeClass('show');
            // $('nav ul .comments-show').removeClass('show');
        });
        $('.data-btn').click(function() {

            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').toggleClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .eight').toggleClass('rotate');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .contact_us21').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan30').removeClass('rotate');
            $('nav ul .off-plan-show30').removeClass('show');
            // $('nav ul .leads-show').removeClass('show');
            // $('nav ul .asd-show').removeClass('show');
            // $('nav ul .data-show').toggleClass('show');
            // $('nav ul .pm-event').removeClass('show');
            // $('nav ul .report-show').removeClass('show');
            // $('nav ul .au-show').removeClass('show');
            // $('nav ul .pm-show').removeClass('show');
            // $('nav ul .eight').toggleClass('rotate');
            // $('nav ul .meet-event').removeClass('show');
            // $('nav ul .setting-show').removeClass('show');
            // $('nav ul .comments-show').removeClass('show');
        });
        $('.comments-btn').click(function() {



            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').toggleClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .twelve').toggleClass('rotate');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .contact_us21').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan30').removeClass('rotate');
            $('nav ul .off-plan-show30').removeClass('show');

            // $('nav ul .leads-show').removeClass('show');
            // $('nav ul .asd-show').removeClass('show');
            // $('nav ul .data-show').removeClass('show');
            // $('nav ul .pm-event').removeClass('show');
            // $('nav ul .report-show').removeClass('show');
            // $('nav ul .au-show').removeClass('show');
            // $('nav ul .pm-show').removeClass('show');
            // $('nav ul .meet-event').removeClass('show');
            // $('nav ul .setting-show').removeClass('show');
            // $('nav ul .comments-show').toggleClass('show');
            // $('nav ul .twelve').toggleClass('rotate');
        });
        $('.data-btn2').click(function() {

            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').toggleClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .five-five').toggleClass('rotate');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .contact_us21').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan30').removeClass('rotate');
            $('nav ul .off-plan-show30').removeClass('show');

            // $('nav ul .leads-show').removeClass('show');
            // $('nav ul .asd-show').removeClass('show');
            // $('nav ul .data-show2').toggleClass('show');
            // $('nav ul .pm-event').removeClass('show');
            // $('nav ul .report-show').removeClass('show');
            // $('nav ul .au-show').removeClass('show');
            // $('nav ul .pm-show').removeClass('show');
            // $('nav ul .five-five').toggleClass('rotate');
            // $('nav ul .meet-event').removeClass('show');
            // $('nav ul .setting-show').removeClass('show');
            // $('nav ul .comments-show').removeClass('show');
        });
        $('.data-btn20').click(function() {

            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').toggleClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .twenty').toggleClass('rotate');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .contact_us21').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan30').removeClass('rotate');
            $('nav ul .off-plan-show30').removeClass('show');

            // $('nav ul .leads-show').removeClass('show');
            // $('nav ul .asd-show').removeClass('show');
            // $('nav ul .data-show20').toggleClass('show');
            // $('nav ul .pm-event').removeClass('show');
            // $('nav ul .report-show').removeClass('show');
            // $('nav ul .au-show').removeClass('show');
            // $('nav ul .pm-show').removeClass('show');
            // $('nav ul .twenty').toggleClass('rotate');
            // $('nav ul .meet-event').removeClass('show');
            // $('nav ul .setting-show').removeClass('show');
        });
        $('.data-btn3').click(function() {

            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').toggleClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .building').toggleClass('rotate');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .contact_us21').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan30').removeClass('rotate');
            $('nav ul .off-plan-show30').removeClass('show');

            // $('nav ul .data-show3').toggleClass('show');
        });
        $('.report-btn').click(function() {


            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').toggleClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .third').toggleClass('rotate');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .contact_us21').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan30').removeClass('rotate');
            $('nav ul .off-plan-show30').removeClass('show');

            // $('nav ul .leads-show').removeClass('show');
            // $('nav ul .asd-show').removeClass('show');
            // $('nav ul .pm-event').removeClass('show');
            // $('nav ul .report-show').toggleClass('show');
            // $('nav ul .au-show').removeClass('show');
            // $('nav ul .pm-show').removeClass('show');
            // $('nav ul .third').toggleClass('rotate');
            // $('nav ul .meet-event').removeClass('show');
            // $('nav ul .setting-show').removeClass('show');
            // $('nav ul .comments-show').removeClass('show');
        });
        $('.au-btn').click(function() {


            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').toggleClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .fourth').toggleClass('rotate');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .contact_us21').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan30').removeClass('rotate');
            $('nav ul .off-plan-show30').removeClass('show');

            // $('nav ul .leads-show').removeClass('show');
            // $('nav ul .asd-show').removeClass('show');
            // $('nav ul .report-show').removeClass('show');
            // $('nav ul .pm-event').removeClass('show');
            // $('nav ul .au-show').toggleClass('show');
            // $('nav ul .pm-show').removeClass('show');
            // $('nav ul .fourth').toggleClass('rotate');
            // $('nav ul .meet-event').removeClass('show');
            // $('nav ul .setting-show').removeClass('show');
            // $('nav ul .comments-show').removeClass('show');
        });
        $('.pm-btn').click(function() {


            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').toggleClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .fifth').toggleClass('rotate');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .contact_us21').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan30').removeClass('rotate');
            $('nav ul .off-plan-show30').removeClass('show');
            // $('nav ul .leads-show').removeClass('show');
            // $('nav ul .asd-show').removeClass('show');
            // $('nav ul .report-show').removeClass('show');
            // $('nav ul .au-show').removeClass('show');
            // $('nav ul .pm-event').removeClass('show');
            // $('nav ul .pm-show').toggleClass('show');
            // $('nav ul .fifth').toggleClass('rotate');
            // $('nav ul .meet-event').removeClass('show');
            // $('nav ul .setting-show').removeClass('show');
            // $('nav ul .comments-show').removeClass('show');
        });
        $('.pmeventa').click(function() {


            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').toggleClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .pm-events').toggleClass('rotate');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .contact_us21').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan30').removeClass('rotate');
            $('nav ul .off-plan-show30').removeClass('show');

            // $('nav ul .leads-show').removeClass('show');
            // $('nav ul .asd-show').removeClass('show');
            // $('nav ul .report-show').removeClass('show');
            // $('nav ul .au-show').removeClass('show');
            // $('nav ul .pm-show').removeClass('show');
            // $('nav ul .pm-event').toggleClass('show');
            // $('nav ul .pm-events').toggleClass('rotate');
            // $('nav ul .meet-event').removeClass('show');
            // $('nav ul .setting-show').removeClass('show');
            // $('nav ul .comments-show').removeClass('show');
        });
        $('.ap-btn').click(function() {



            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').toggleClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .sixth').toggleClass('rotate');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .contact_us21').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan30').removeClass('rotate');
            $('nav ul .off-plan-show30').removeClass('show');

            // $('nav ul .leads-show').removeClass('show');
            // $('nav ul .asd-show').removeClass('show');
            // $('nav ul .report-show').removeClass('show');
            // $('nav ul .au-show').removeClass('show');
            // $('nav ul .ap-show').toggleClass('show');
            // $('nav ul .sixth').toggleClass('rotate');
            // $('nav ul .meet-event').removeClass('show');
            // $('nav ul .setting-show').removeClass('show');
            // $('nav ul .comments-show').removeClass('show');
        });
        $('.meet-btn').click(function() {


            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').toggleClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .nine').toggleClass('rotate');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .contact_us21').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan30').removeClass('rotate');
            $('nav ul .off-plan-show30').removeClass('show');

            // $('nav ul .leads-show').removeClass('show');
            // $('nav ul .asd-show').removeClass('show');
            // $('nav ul .report-show').removeClass('show');
            // $('nav ul .au-show').removeClass('show');
            // $('nav ul .pm-event').removeClass('show');
            // $('nav ul .meet-event').removeClass('show');
            // $('nav ul .pm-show').removeClass('show');
            // $('nav ul .meet-show').toggleClass('show');
            // $('nav ul .nine').toggleClass('rotate');
            // $('nav ul .setting-show').removeClass('show');
            // $('nav ul .comments-show').removeClass('show');
        });
        $('.setting-btn').click(function() {


            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').toggleClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .ten').toggleClass('rotate');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .contact_us21').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan30').removeClass('rotate');
            $('nav ul .off-plan-show30').removeClass('show');
            // $('nav ul .leads-show').removeClass('show');
            // $('nav ul .asd-show').removeClass('show');
            // $('nav ul .report-show').removeClass('show');
            // $('nav ul .au-show').removeClass('show');
            // $('nav ul .pm-event').removeClass('show');
            // $('nav ul .meet-event').removeClass('show');
            // $('nav ul .pm-show').removeClass('show');
            // $('nav ul .meet-show').removeClass('show');
            // $('nav ul .setting-show').toggleClass('show');
            // $('nav ul .ten').toggleClass('rotate');
            // $('nav ul .comments-show').removeClass('show');
        });
        $('.sync-btn').click(function() {


        $('nav ul .asd-show').removeClass('show');
        $('nav ul .comments-show').removeClass('show');
        $('nav ul .data-show').removeClass('show');
        $('nav ul .data-show3').removeClass('show');
        $('nav ul .data-show20').removeClass('show');
        $('nav ul .data-show2').removeClass('show');
        $('nav ul .report-show').removeClass('show');
        $('nav ul .au-show').removeClass('show');
        $('nav ul .pm-event').removeClass('show');
        $('nav ul .pm-show').removeClass('show');
        $('nav ul .ap-show').removeClass('show');
        $('nav ul .meet-show').removeClass('show');
        $('nav ul .setting-show').removeClass('show');
        $('nav ul .sync-show').toggleClass('show');
        $('nav ul .leads-show').removeClass('show');
        $('nav ul .fourteen').toggleClass('rotate');
        $('nav ul .data-show21').removeClass('show');
        $('nav ul .contact_us21').removeClass('rotate');
        $('nav ul .subscriptions-show').removeClass('show');
        $('nav ul .off-plan30').removeClass('rotate');
        $('nav ul .off-plan-show30').removeClass('show');
});
    $('.data-btn21').click(function() {
        $('nav ul .asd-show').removeClass('show');
        $('nav ul .comments-show').removeClass('show');
        $('nav ul .data-show').removeClass('show');
        $('nav ul .data-show3').removeClass('show');
        $('nav ul .data-show20').removeClass('show');
        $('nav ul .data-show2').removeClass('show');
        $('nav ul .report-show').removeClass('show');
        $('nav ul .au-show').removeClass('show');
        $('nav ul .pm-event').removeClass('show');
        $('nav ul .pm-show').removeClass('show');
        $('nav ul .ap-show').removeClass('show');
        $('nav ul .meet-show').removeClass('show');
        $('nav ul .setting-show').removeClass('show');
        $('nav ul .sync-show').removeClass('show');
        $('nav ul .leads-show').removeClass('show');
        $('nav ul .data-show21').toggleClass('show');
        $('nav ul .contact_us21').toggleClass('rotate');
        $('nav ul .subscriptions-show').removeClass('show');
        $('nav ul .off-plan30').removeClass('rotate');
        $('nav ul .off-plan-show30').removeClass('show');

    });
    $('.subscriptions-btn').click(function() {
        $('nav ul .asd-show').removeClass('show');
        $('nav ul .comments-show').removeClass('show');
        $('nav ul .data-show').removeClass('show');
        $('nav ul .data-show3').removeClass('show');
        $('nav ul .data-show20').removeClass('show');
        $('nav ul .data-show2').removeClass('show');
        $('nav ul .report-show').removeClass('show');
        $('nav ul .au-show').removeClass('show');
        $('nav ul .pm-event').removeClass('show');
        $('nav ul .pm-show').removeClass('show');
        $('nav ul .ap-show').removeClass('show');
        $('nav ul .meet-show').removeClass('show');
        $('nav ul .setting-show').removeClass('show');
        $('nav ul .sync-show').removeClass('show');
        $('nav ul .leads-show').removeClass('show');
        $('nav ul .data-show21').removeClass('show');
        $('nav ul .subscriptions-span').toggleClass('rotate');
        $('nav ul .subscriptions-show').toggleClass('show');
        $('nav ul .off-plan30').removeClass('rotate');
        $('nav ul .off-plan-show30').removeClass('show');

    });
    $('.data-btn30').click(function() {
        $('nav ul .asd-show').removeClass('show');
        $('nav ul .comments-show').removeClass('show');
        $('nav ul .data-show').removeClass('show');
        $('nav ul .data-show3').removeClass('show');
        $('nav ul .data-show20').removeClass('show');
        $('nav ul .data-show2').removeClass('show');
        $('nav ul .report-show').removeClass('show');
        $('nav ul .au-show').removeClass('show');
        $('nav ul .pm-event').removeClass('show');
        $('nav ul .pm-show').removeClass('show');
        $('nav ul .ap-show').removeClass('show');
        $('nav ul .meet-show').removeClass('show');
        $('nav ul .setting-show').removeClass('show');
        $('nav ul .sync-show').removeClass('show');
        $('nav ul .leads-show').removeClass('show');
        $('nav ul .data-show21').removeClass('show');
        $('nav ul .subscriptions-span').removeClass('rotate');
        $('nav ul .subscriptions-show').removeClass('show');
        $('nav ul .off-plan30').toggleClass('rotate');
        $('nav ul .off-plan-show30').toggleClass('show');
    });

        $('.data-btn63').click(function() {
            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .subscriptions-span').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan63').toggleClass('rotate');
            $('nav ul .off-plan-show63').toggleClass('show');
        });

        $('.data-btn56').click(function() {
            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .subscriptions-span').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan56').toggleClass('rotate');
            $('nav ul .off-plan-show56').toggleClass('show');
        });




          $('.data-btn31').click(function (e) {
            e.preventDefault(); // Prevent anchor default behavior

            // Remove "show" and "rotate" classes from other dropdowns
            $('nav ul .off-plan-show31').not($(this).next('ul')).removeClass('show').slideUp();
            $('nav ul .off-plan31').not($(this).find('.off-plan31')).removeClass('rotate');

            // Toggle current dropdown
            $(this).next('ul').toggleClass('show').slideToggle(); // For smooth animation
            $(this).find('.off-plan31').toggleClass('rotate');
        });

        $('.data-btn32').click(function (e) {
            e.preventDefault(); // Prevent anchor default behavior

            // Remove "show" and "rotate" classes from other dropdowns
            $('nav ul .off-plan-show32').not($(this).next('ul')).removeClass('show').slideUp();
            $('nav ul .off-plan32').not($(this).find('.off-plan32')).removeClass('rotate');

            // Toggle current dropdown
            $(this).next('ul').toggleClass('show').slideToggle(); // For smooth animation
            $(this).find('.off-plan32').toggleClass('rotate');
        });

        $('.data-btn55').click(function() {
            $('nav ul .asd-show').removeClass('show');
            $('nav ul .comments-show').removeClass('show');
            $('nav ul .data-show').removeClass('show');
            $('nav ul .data-show3').removeClass('show');
            $('nav ul .data-show20').removeClass('show');
            $('nav ul .data-show2').removeClass('show');
            $('nav ul .report-show').removeClass('show');
            $('nav ul .au-show').removeClass('show');
            $('nav ul .pm-event').removeClass('show');
            $('nav ul .pm-show').removeClass('show');
            $('nav ul .ap-show').removeClass('show');
            $('nav ul .meet-show').removeClass('show');
            $('nav ul .setting-show').removeClass('show');
            $('nav ul .sync-show').removeClass('show');
            $('nav ul .leads-show').removeClass('show');
            $('nav ul .data-show21').removeClass('show');
            $('nav ul .subscriptions-span').removeClass('rotate');
            $('nav ul .subscriptions-show').removeClass('show');
            $('nav ul .off-plan55').toggleClass('rotate');
            $('nav ul .off-plan-show55').toggleClass('show');
        });

        $('nav ul li').click(function() {
            // $(this).addClass('active').siblings().removeClass('active');
        });
    </script>
    {{-- logout aut --}}
    <script>
        $(document).ready(function() {
            var role = $('#role').text();
            // console.log(role);
            if (role == "3") {
                var timeout = 900000;
                var ideltime = null;
                $('*').bind(
                    'mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick',
                    function() {
                        clearTimeout(ideltime);
                        ideltime = setTimeout(function() {
                            document.getElementById('logout-form').submit();
                        }, timeout);
                    });
                $('body').trigger('mousemove');
            }
        });
    </script>
</body>

</html>
