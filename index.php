<?php

include 'db.php';

$sql_cat = $_GET['category'] ? "AND menu_category_id='".mysqli_real_escape_string($GLOBALS['link'],$_GET['category'])."'" : "";
$sql_search = $_GET['q'] ? "AND ( ".
		"MATCH(`product_name`,`category_name`,`ingredients_list`) AGAINST('".mysqli_real_escape_string($GLOBALS['link'],$_GET['q'])."')".
		"OR product_name LIKE '%".mysqli_real_escape_string($GLOBALS['link'],$_GET['q'])."%'".
		"OR category_name LIKE '%".mysqli_real_escape_string($GLOBALS['link'],$_GET['q'])."%'".
		"OR ingredients_list LIKE '%".mysqli_real_escape_string($GLOBALS['link'],$_GET['q'])."%'".
	")"
 : "";

if($query_products = mysqli_query($link,"SELECT * FROM products WHERE price_shop<>0 AND photo<>'' ".$sql_cat." ".$sql_search." ORDER BY menu_category_id")){
	while($row = mysqli_fetch_assoc($query_products)){
		$products[] = $row;
		$products_categories[$row['menu_category_id']][] = $row;
	}
}

if($query_categories = mysqli_query($link,"SELECT * FROM products WHERE price_shop<>0 AND photo<>'' ORDER BY menu_category_id")){
	while($row = mysqli_fetch_assoc($query_categories)){
		$categories[$row['menu_category_id']][] = $row;
	}
}

// echo '<pre>';
// print_r($products_categories);
// echo '</pre>';

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!--[CDATA[YII-BLOCK-HEAD]]-->
  <link rel="shortcut icon" href="/uploads/shop_gurmani.postershop.me/Config/LOGO-falag-1.png" type="image/png">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GURMANI. Море вкуса для тебя</title>
  <meta property="og:title" content="GURMANI. Море вкуса для тебя">
  <meta name="description"
    content="Нам удалось создать достойный продукт, в котором мы уверены на 100%. Мы отвечаем за высокое качество каждого ингредиента и скорость доставки.Наша цель радовать вас, доставляя вкусную еду. Приносить удовольствие и впечатления.">
  <meta property="og:description"
    content="Нам удалось создать достойный продукт, в котором мы уверены на 100%. Мы отвечаем за высокое качество каждого ингредиента и скорость доставки.Наша цель радовать вас, доставляя вкусную еду. Приносить удовольствие и впечатления.">
  <!-- <meta property="og:image" content="http://gurmanikzn.ru/uploads/shop_gurmani.postershop.me/Config/LOGO-falag-1.png"> -->
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

  <!-- Яндекс webmaster -->
  <meta name="yandex-verification" content="c03334cfa7405dcd" />

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="style/cart.css<?php echo '?'.$hash ?>">

  <style type="text/css">
  /*! normalize.css v3.0.3 | MIT License | github.com/necolas/normalize.css */
  html {
    font-family: sans-serif;
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%
  }

  body {
    margin: 0
  }

  article,
  aside,
  details,
  figcaption,
  figure,
  footer,
  header,
  hgroup,
  main,
  menu,
  nav,
  section,
  summary {
    display: block
  }

  audio,
  canvas,
  progress,
  video {
    display: inline-block;
    vertical-align: baseline
  }

  audio:not([controls]) {
    display: none;
    height: 0
  }

  [hidden],
  template {
    display: none
  }

  a {
    background-color: transparent
  }

  a:active,
  a:hover {
    outline: 0
  }

  abbr[title] {
    border-bottom: none;
    text-decoration: underline;
    text-decoration: underline dotted
  }

  b,
  strong {
    font-weight: 700
  }

  dfn {
    font-style: italic
  }

  h1 {
    font-size: 2em;
    margin: .67em 0
  }

  mark {
    background: #ff0;
    color: #000
  }

  small {
    font-size: 80%
  }

  sub,
  sup {
    font-size: 75%;
    line-height: 0;
    position: relative;
    vertical-align: baseline
  }

  sup {
    top: -.5em
  }

  sub {
    bottom: -.25em
  }

  img {
    border: 0
  }

  svg:not(:root) {
    overflow: hidden
  }

  figure {
    margin: 1em 40px
  }

  hr {
    box-sizing: content-box;
    height: 0
  }

  pre {
    overflow: auto
  }

  code,
  kbd,
  pre,
  samp {
    font-family: monospace, monospace;
    font-size: 1em
  }

  button,
  input,
  optgroup,
  select,
  textarea {
    color: inherit;
    font: inherit;
    margin: 0
  }

  button {
    overflow: visible
  }

  button,
  select {
    text-transform: none
  }

  button,
  html input[type=button],
  input[type=reset],
  input[type=submit] {
    -webkit-appearance: button;
    cursor: pointer
  }

  button[disabled],
  html input[disabled] {
    cursor: default
  }

  button::-moz-focus-inner,
  input::-moz-focus-inner {
    border: 0;
    padding: 0
  }

  input {
    line-height: normal
  }

  input[type=checkbox],
  input[type=radio] {
    box-sizing: border-box;
    padding: 0
  }

  input[type=number]::-webkit-inner-spin-button,
  input[type=number]::-webkit-outer-spin-button {
    height: auto
  }

  input[type=search] {
    -webkit-appearance: textfield;
    box-sizing: content-box
  }

  input[type=search]::-webkit-search-cancel-button,
  input[type=search]::-webkit-search-decoration {
    -webkit-appearance: none
  }

  fieldset {
    border: 1px solid silver;
    margin: 0 2px;
    padding: .35em .625em .75em
  }

  legend {
    border: 0;
    padding: 0
  }

  textarea {
    overflow: auto
  }

  optgroup {
    font-weight: 700
  }

  table {
    border-collapse: collapse;
    border-spacing: 0
  }

  td,
  th {
    padding: 0
  }

  /*! Source: https://github.com/h5bp/html5-boilerplate/blob/master/src/css/main.css */
  @media print {

    *,
    :after,
    :before {
      color: #000 !important;
      text-shadow: none !important;
      background: transparent !important;
      box-shadow: none !important
    }

    a,
    a:visited {
      text-decoration: underline
    }

    a[href]:after {
      content: " ("attr(href) ")"
    }

    abbr[title]:after {
      content: " ("attr(title) ")"
    }

    a[href^="#"]:after,
    a[href^="javascript:"]:after {
      content: ""
    }

    blockquote,
    pre {
      border: 1px solid #999;
      page-break-inside: avoid
    }

    thead {
      display: table-header-group
    }

    img,
    tr {
      page-break-inside: avoid
    }

    img {
      max-width: 100% !important
    }

    h2,
    h3,
    p {
      orphans: 3;
      widows: 3
    }

    h2,
    h3 {
      page-break-after: avoid
    }

    .advantage {
      text-align: center !important;
    }

    .navbar {
      display: none
    }

    .btn>.caret,
    .dropup>.btn>.caret {
      border-top-color: #000 !important
    }

    .label {
      border: 1px solid #000
    }

    .table {
      border-collapse: collapse !important
    }

    .table td,
    .table th {
      background-color: #fff !important
    }

    .table-bordered td,
    .table-bordered th {
      border: 1px solid #ddd !important
    }
  }

  *,
  :after,
  :before {
    box-sizing: border-box
  }

  html {
    font-size: 10px;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0)
  }

  body {
    font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
    font-size: 16px;
    line-height: 1.42857143;
    color: #333;
    background-color: #fff
  }

  button,
  input,
  select,
  textarea {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit
  }

  a {
    color: #337ab7;
    text-decoration: none
  }

  a:focus,
  a:hover {
    color: #23527c;
    text-decoration: underline
  }

  a:focus {
    outline: 5px auto -webkit-focus-ring-color;
    outline-offset: -2px
  }

  figure {
    margin: 0
  }

  img {
    vertical-align: middle
  }

  .img-responsive {
    display: block;
    max-width: 100%;
    height: auto
  }

  .img-rounded {
    border-radius: 6px
  }

  .img-thumbnail {
    padding: 4px;
    line-height: 1.42857143;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: all .2s ease-in-out;
    display: inline-block;
    max-width: 100%;
    height: auto
  }

  .img-circle {
    border-radius: 50%
  }

  hr {
    margin-top: 20px;
    margin-bottom: 20px;
    border: 0;
    border-top: 1px solid #eee
  }

  .sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0
  }

  .sr-only-focusable:active,
  .sr-only-focusable:focus {
    position: static;
    width: auto;
    height: auto;
    margin: 0;
    overflow: visible;
    clip: auto
  }

  [role=button] {
    cursor: pointer
  }

  .container {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto
  }

  @media (min-width:768px) {
    .container {
      /*width:750px*/
    }
  }

  @media (min-width:992px) {
    .container {
      width: 970px
    }
  }

  @media (min-width:1200px) {
    .container {
      width: 1170px
    }
  }

  .container-fluid {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto
  }

  .row {
    margin-right: -15px;
    margin-left: -15px
  }

  .row-no-gutters {
    margin-right: 0;
    margin-left: 0
  }

  .row-no-gutters [class*=col-] {
    padding-right: 0;
    padding-left: 0
  }

  .col-lg-1,
  .col-lg-2,
  .col-lg-3,
  .col-lg-4,
  .col-lg-5,
  .col-lg-6,
  .col-lg-7,
  .col-lg-8,
  .col-lg-9,
  .col-lg-10,
  .col-lg-11,
  .col-lg-12,
  .col-md-1,
  .col-md-2,
  .col-md-3,
  .col-md-4,
  .col-md-5,
  .col-md-6,
  .col-md-7,
  .col-md-8,
  .col-md-9,
  .col-md-10,
  .col-md-11,
  .col-md-12,
  .col-sm-1,
  .col-sm-2,
  .col-sm-3,
  .col-sm-4,
  .col-sm-5,
  .col-sm-6,
  .col-sm-7,
  .col-sm-8,
  .col-sm-9,
  .col-sm-10,
  .col-sm-11,
  .col-sm-12,
  .col-xs-1,
  .col-xs-2,
  .col-xs-3,
  .col-xs-4,
  .col-xs-5,
  .col-xs-6,
  .col-xs-7,
  .col-xs-8,
  .col-xs-9,
  .col-xs-10,
  .col-xs-11,
  .col-xs-12 {
    position: relative;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px
  }

  .col-xs-1,
  .col-xs-2,
  .col-xs-3,
  .col-xs-4,
  .col-xs-5,
  .col-xs-6,
  .col-xs-7,
  .col-xs-8,
  .col-xs-9,
  .col-xs-10,
  .col-xs-11,
  .col-xs-12 {
    float: left
  }

  .col-xs-12 {
    width: 100%
  }

  .col-xs-11 {
    width: 91.66666667%
  }

  .col-xs-10 {
    width: 83.33333333%
  }

  .col-xs-9 {
    width: 75%
  }

  .col-xs-8 {
    width: 66.66666667%
  }

  .col-xs-7 {
    width: 58.33333333%
  }

  .col-xs-6 {
    width: 50%
  }

  .col-xs-5 {
    width: 41.66666667%
  }

  .col-xs-4 {
    width: 33.33333333%
  }

  .col-xs-3 {
    width: 25%
  }

  .col-xs-2 {
    width: 16.66666667%
  }

  .col-xs-1 {
    width: 8.33333333%
  }

  .col-xs-pull-12 {
    right: 100%
  }

  .col-xs-pull-11 {
    right: 91.66666667%
  }

  .col-xs-pull-10 {
    right: 83.33333333%
  }

  .col-xs-pull-9 {
    right: 75%
  }

  .col-xs-pull-8 {
    right: 66.66666667%
  }

  .col-xs-pull-7 {
    right: 58.33333333%
  }

  .col-xs-pull-6 {
    right: 50%
  }

  .col-xs-pull-5 {
    right: 41.66666667%
  }

  .col-xs-pull-4 {
    right: 33.33333333%
  }

  .col-xs-pull-3 {
    right: 25%
  }

  .col-xs-pull-2 {
    right: 16.66666667%
  }

  .col-xs-pull-1 {
    right: 8.33333333%
  }

  .col-xs-pull-0 {
    right: auto
  }

  .col-xs-push-12 {
    left: 100%
  }

  .col-xs-push-11 {
    left: 91.66666667%
  }

  .col-xs-push-10 {
    left: 83.33333333%
  }

  .col-xs-push-9 {
    left: 75%
  }

  .col-xs-push-8 {
    left: 66.66666667%
  }

  .col-xs-push-7 {
    left: 58.33333333%
  }

  .col-xs-push-6 {
    left: 50%
  }

  .col-xs-push-5 {
    left: 41.66666667%
  }

  .col-xs-push-4 {
    left: 33.33333333%
  }

  .col-xs-push-3 {
    left: 25%
  }

  .col-xs-push-2 {
    left: 16.66666667%
  }

  .col-xs-push-1 {
    left: 8.33333333%
  }

  .col-xs-push-0 {
    left: auto
  }

  .col-xs-offset-12 {
    margin-left: 100%
  }

  .col-xs-offset-11 {
    margin-left: 91.66666667%
  }

  .col-xs-offset-10 {
    margin-left: 83.33333333%
  }

  .col-xs-offset-9 {
    margin-left: 75%
  }

  .col-xs-offset-8 {
    margin-left: 66.66666667%
  }

  .col-xs-offset-7 {
    margin-left: 58.33333333%
  }

  .col-xs-offset-6 {
    margin-left: 50%
  }

  .col-xs-offset-5 {
    margin-left: 41.66666667%
  }

  .col-xs-offset-4 {
    margin-left: 33.33333333%
  }

  .col-xs-offset-3 {
    margin-left: 25%
  }

  .col-xs-offset-2 {
    margin-left: 16.66666667%
  }

  .col-xs-offset-1 {
    margin-left: 8.33333333%
  }

  .col-xs-offset-0 {
    margin-left: 0
  }

  @media (min-width:768px) {

    .col-sm-1,
    .col-sm-2,
    .col-sm-3,
    .col-sm-4,
    .col-sm-5,
    .col-sm-6,
    .col-sm-7,
    .col-sm-8,
    .col-sm-9,
    .col-sm-10,
    .col-sm-11,
    .col-sm-12 {
      float: left
    }

    .col-sm-12 {
      width: 100%
    }

    .col-sm-11 {
      width: 91.66666667%
    }

    .col-sm-10 {
      width: 83.33333333%
    }

    .col-sm-9 {
      width: 75%
    }

    .col-sm-8 {
      width: 66.66666667%
    }

    .col-sm-7 {
      width: 58.33333333%
    }

    .col-sm-6 {
      width: 50%
    }

    .col-sm-5 {
      width: 41.66666667%
    }

    .col-sm-4 {
      width: 33.33333333%
    }

    .col-sm-3 {
      width: 25%
    }

    .col-sm-2 {
      width: 16.66666667%
    }

    .col-sm-1 {
      width: 8.33333333%
    }

    .col-sm-pull-12 {
      right: 100%
    }

    .col-sm-pull-11 {
      right: 91.66666667%
    }

    .col-sm-pull-10 {
      right: 83.33333333%
    }

    .col-sm-pull-9 {
      right: 75%
    }

    .col-sm-pull-8 {
      right: 66.66666667%
    }

    .col-sm-pull-7 {
      right: 58.33333333%
    }

    .col-sm-pull-6 {
      right: 50%
    }

    .col-sm-pull-5 {
      right: 41.66666667%
    }

    .col-sm-pull-4 {
      right: 33.33333333%
    }

    .col-sm-pull-3 {
      right: 25%
    }

    .col-sm-pull-2 {
      right: 16.66666667%
    }

    .col-sm-pull-1 {
      right: 8.33333333%
    }

    .col-sm-pull-0 {
      right: auto
    }

    .col-sm-push-12 {
      left: 100%
    }

    .col-sm-push-11 {
      left: 91.66666667%
    }

    .col-sm-push-10 {
      left: 83.33333333%
    }

    .col-sm-push-9 {
      left: 75%
    }

    .col-sm-push-8 {
      left: 66.66666667%
    }

    .col-sm-push-7 {
      left: 58.33333333%
    }

    .col-sm-push-6 {
      left: 50%
    }

    .col-sm-push-5 {
      left: 41.66666667%
    }

    .col-sm-push-4 {
      left: 33.33333333%
    }

    .col-sm-push-3 {
      left: 25%
    }

    .col-sm-push-2 {
      left: 16.66666667%
    }

    .col-sm-push-1 {
      left: 8.33333333%
    }

    .col-sm-push-0 {
      left: auto
    }

    .col-sm-offset-12 {
      margin-left: 100%
    }

    .col-sm-offset-11 {
      margin-left: 91.66666667%
    }

    .col-sm-offset-10 {
      margin-left: 83.33333333%
    }

    .col-sm-offset-9 {
      margin-left: 75%
    }

    .col-sm-offset-8 {
      margin-left: 66.66666667%
    }

    .col-sm-offset-7 {
      margin-left: 58.33333333%
    }

    .col-sm-offset-6 {
      margin-left: 50%
    }

    .col-sm-offset-5 {
      margin-left: 41.66666667%
    }

    .col-sm-offset-4 {
      margin-left: 33.33333333%
    }

    .col-sm-offset-3 {
      margin-left: 25%
    }

    .col-sm-offset-2 {
      margin-left: 16.66666667%
    }

    .col-sm-offset-1 {
      margin-left: 8.33333333%
    }

    .col-sm-offset-0 {
      margin-left: 0
    }
  }

  @media (min-width:992px) {

    .col-md-1,
    .col-md-2,
    .col-md-3,
    .col-md-4,
    .col-md-5,
    .col-md-6,
    .col-md-7,
    .col-md-8,
    .col-md-9,
    .col-md-10,
    .col-md-11,
    .col-md-12 {
      float: left
    }

    .col-md-12 {
      width: 100%
    }

    .col-md-11 {
      width: 91.66666667%
    }

    .col-md-10 {
      width: 83.33333333%
    }

    .col-md-9 {
      width: 75%
    }

    .col-md-8 {
      width: 66.66666667%
    }

    .col-md-7 {
      width: 58.33333333%
    }

    .col-md-6 {
      width: 50%
    }

    .col-md-5 {
      width: 41.66666667%
    }

    .col-md-4 {
      width: 33.33333333%
    }

    .col-md-3 {
      width: 25%
    }

    .col-md-2 {
      width: 16.66666667%
    }

    .col-md-1 {
      width: 8.33333333%
    }

    .col-md-pull-12 {
      right: 100%
    }

    .col-md-pull-11 {
      right: 91.66666667%
    }

    .col-md-pull-10 {
      right: 83.33333333%
    }

    .col-md-pull-9 {
      right: 75%
    }

    .col-md-pull-8 {
      right: 66.66666667%
    }

    .col-md-pull-7 {
      right: 58.33333333%
    }

    .col-md-pull-6 {
      right: 50%
    }

    .col-md-pull-5 {
      right: 41.66666667%
    }

    .col-md-pull-4 {
      right: 33.33333333%
    }

    .col-md-pull-3 {
      right: 25%
    }

    .col-md-pull-2 {
      right: 16.66666667%
    }

    .col-md-pull-1 {
      right: 8.33333333%
    }

    .col-md-pull-0 {
      right: auto
    }

    .col-md-push-12 {
      left: 100%
    }

    .col-md-push-11 {
      left: 91.66666667%
    }

    .col-md-push-10 {
      left: 83.33333333%
    }

    .col-md-push-9 {
      left: 75%
    }

    .col-md-push-8 {
      left: 66.66666667%
    }

    .col-md-push-7 {
      left: 58.33333333%
    }

    .col-md-push-6 {
      left: 50%
    }

    .col-md-push-5 {
      left: 41.66666667%
    }

    .col-md-push-4 {
      left: 33.33333333%
    }

    .col-md-push-3 {
      left: 25%
    }

    .col-md-push-2 {
      left: 16.66666667%
    }

    .col-md-push-1 {
      left: 8.33333333%
    }

    .col-md-push-0 {
      left: auto
    }

    .col-md-offset-12 {
      margin-left: 100%
    }

    .col-md-offset-11 {
      margin-left: 91.66666667%
    }

    .col-md-offset-10 {
      margin-left: 83.33333333%
    }

    .col-md-offset-9 {
      margin-left: 75%
    }

    .col-md-offset-8 {
      margin-left: 66.66666667%
    }

    .col-md-offset-7 {
      margin-left: 58.33333333%
    }

    .col-md-offset-6 {
      margin-left: 50%
    }

    .col-md-offset-5 {
      margin-left: 41.66666667%
    }

    .col-md-offset-4 {
      margin-left: 33.33333333%
    }

    .col-md-offset-3 {
      margin-left: 25%
    }

    .col-md-offset-2 {
      margin-left: 16.66666667%
    }

    .col-md-offset-1 {
      margin-left: 8.33333333%
    }

    .col-md-offset-0 {
      margin-left: 0
    }
  }

  @media (min-width:1200px) {

    .col-lg-1,
    .col-lg-2,
    .col-lg-3,
    .col-lg-4,
    .col-lg-5,
    .col-lg-6,
    .col-lg-7,
    .col-lg-8,
    .col-lg-9,
    .col-lg-10,
    .col-lg-11,
    .col-lg-12 {
      float: left
    }

    .col-lg-12 {
      width: 100%
    }

    .col-lg-11 {
      width: 91.66666667%
    }

    .col-lg-10 {
      width: 83.33333333%
    }

    .col-lg-9 {
      width: 75%
    }

    .col-lg-8 {
      width: 66.66666667%
    }

    .col-lg-7 {
      width: 58.33333333%
    }

    .col-lg-6 {
      width: 50%
    }

    .col-lg-5 {
      width: 41.66666667%
    }

    .col-lg-4 {
      width: 33.33333333%
    }

    .col-lg-3 {
      width: 25%
    }

    .col-lg-2 {
      width: 16.66666667%
    }

    .col-lg-1 {
      width: 8.33333333%
    }

    .col-lg-pull-12 {
      right: 100%
    }

    .col-lg-pull-11 {
      right: 91.66666667%
    }

    .col-lg-pull-10 {
      right: 83.33333333%
    }

    .col-lg-pull-9 {
      right: 75%
    }

    .col-lg-pull-8 {
      right: 66.66666667%
    }

    .col-lg-pull-7 {
      right: 58.33333333%
    }

    .col-lg-pull-6 {
      right: 50%
    }

    .col-lg-pull-5 {
      right: 41.66666667%
    }

    .col-lg-pull-4 {
      right: 33.33333333%
    }

    .col-lg-pull-3 {
      right: 25%
    }

    .col-lg-pull-2 {
      right: 16.66666667%
    }

    .col-lg-pull-1 {
      right: 8.33333333%
    }

    .col-lg-pull-0 {
      right: auto
    }

    .col-lg-push-12 {
      left: 100%
    }

    .col-lg-push-11 {
      left: 91.66666667%
    }

    .col-lg-push-10 {
      left: 83.33333333%
    }

    .col-lg-push-9 {
      left: 75%
    }

    .col-lg-push-8 {
      left: 66.66666667%
    }

    .col-lg-push-7 {
      left: 58.33333333%
    }

    .col-lg-push-6 {
      left: 50%
    }

    .col-lg-push-5 {
      left: 41.66666667%
    }

    .col-lg-push-4 {
      left: 33.33333333%
    }

    .col-lg-push-3 {
      left: 25%
    }

    .col-lg-push-2 {
      left: 16.66666667%
    }

    .col-lg-push-1 {
      left: 8.33333333%
    }

    .col-lg-push-0 {
      left: auto
    }

    .col-lg-offset-12 {
      margin-left: 100%
    }

    .col-lg-offset-11 {
      margin-left: 91.66666667%
    }

    .col-lg-offset-10 {
      margin-left: 83.33333333%
    }

    .col-lg-offset-9 {
      margin-left: 75%
    }

    .col-lg-offset-8 {
      margin-left: 66.66666667%
    }

    .col-lg-offset-7 {
      margin-left: 58.33333333%
    }

    .col-lg-offset-6 {
      margin-left: 50%
    }

    .col-lg-offset-5 {
      margin-left: 41.66666667%
    }

    .col-lg-offset-4 {
      margin-left: 33.33333333%
    }

    .col-lg-offset-3 {
      margin-left: 25%
    }

    .col-lg-offset-2 {
      margin-left: 16.66666667%
    }

    .col-lg-offset-1 {
      margin-left: 8.33333333%
    }

    .col-lg-offset-0 {
      margin-left: 0
    }
  }

  .clearfix:after,
  .clearfix:before,
  .container-fluid:after,
  .container-fluid:before,
  .container:after,
  .container:before,
  .row:after,
  .row:before {
    display: table;
    content: " "
  }

  .clearfix:after,
  .container-fluid:after,
  .container:after,
  .row:after {
    clear: both
  }

  .center-block {
    display: block;
    margin-right: auto;
    margin-left: auto
  }

  .pull-right {
    float: right !important
  }

  .pull-left {
    float: left !important
  }

  .hide {
    display: none !important
  }

  .show {
    display: block !important
  }

  .invisible {
    visibility: hidden
  }

  .text-hide {
    font: 0/0 a;
    color: transparent;
    text-shadow: none;
    background-color: transparent;
    border: 0
  }

  .hidden {
    display: none !important
  }

  .affix {
    position: fixed
  }

  @-ms-viewport {
    width: device-width
  }

  .visible-lg,
  .visible-lg-block,
  .visible-lg-inline,
  .visible-lg-inline-block,
  .visible-md,
  .visible-md-block,
  .visible-md-inline,
  .visible-md-inline-block,
  .visible-sm,
  .visible-sm-block,
  .visible-sm-inline,
  .visible-sm-inline-block,
  .visible-xs,
  .visible-xs-block,
  .visible-xs-inline,
  .visible-xs-inline-block {
    display: none !important
  }

  @media (max-width:767px) {
    .visible-xs {
      display: block !important
    }

    table.visible-xs {
      display: table !important
    }

    tr.visible-xs {
      display: table-row !important
    }

    td.visible-xs,
    th.visible-xs {
      display: table-cell !important
    }
  }

  @media (max-width:767px) {
    .visible-xs-block {
      display: block !important
    }
  }

  @media (max-width:767px) {
    .visible-xs-inline {
      display: inline !important
    }
  }

  @media (max-width:767px) {
    .visible-xs-inline-block {
      display: inline-block !important
    }
  }

  @media (min-width:768px) and (max-width:991px) {
    .visible-sm {
      display: block !important
    }

    table.visible-sm {
      display: table !important
    }

    tr.visible-sm {
      display: table-row !important
    }

    td.visible-sm,
    th.visible-sm {
      display: table-cell !important
    }
  }

  @media (min-width:768px) and (max-width:991px) {
    .visible-sm-block {
      display: block !important
    }
  }

  @media (min-width:768px) and (max-width:991px) {
    .visible-sm-inline {
      display: inline !important
    }
  }

  @media (min-width:768px) and (max-width:991px) {
    .visible-sm-inline-block {
      display: inline-block !important
    }
  }

  @media (min-width:992px) and (max-width:1199px) {
    .visible-md {
      display: block !important
    }

    table.visible-md {
      display: table !important
    }

    tr.visible-md {
      display: table-row !important
    }

    td.visible-md,
    th.visible-md {
      display: table-cell !important
    }
  }

  @media (min-width:992px) and (max-width:1199px) {
    .visible-md-block {
      display: block !important
    }
  }

  @media (min-width:992px) and (max-width:1199px) {
    .visible-md-inline {
      display: inline !important
    }
  }

  @media (min-width:992px) and (max-width:1199px) {
    .visible-md-inline-block {
      display: inline-block !important
    }
  }

  @media (min-width:1200px) {
    .visible-lg {
      display: block !important
    }

    table.visible-lg {
      display: table !important
    }

    tr.visible-lg {
      display: table-row !important
    }

    td.visible-lg,
    th.visible-lg {
      display: table-cell !important
    }
  }

  @media (min-width:1200px) {
    .visible-lg-block {
      display: block !important
    }
  }

  @media (min-width:1200px) {
    .visible-lg-inline {
      display: inline !important
    }
  }

  @media (min-width:1200px) {
    .visible-lg-inline-block {
      display: inline-block !important
    }
  }

  @media (max-width:767px) {
    .hidden-xs {
      display: none !important
    }
  }

  @media (min-width:768px) and (max-width:991px) {
    .hidden-sm {
      display: none !important
    }
  }

  @media (min-width:992px) and (max-width:1199px) {
    .hidden-md {
      display: none !important
    }
  }

  @media (min-width:1200px) {
    .hidden-lg {
      display: none !important
    }
  }

  .visible-print {
    display: none !important
  }

  @media print {
    .visible-print {
      display: block !important
    }

    table.visible-print {
      display: table !important
    }

    tr.visible-print {
      display: table-row !important
    }

    td.visible-print,
    th.visible-print {
      display: table-cell !important
    }
  }

  .visible-print-block {
    display: none !important
  }

  @media print {
    .visible-print-block {
      display: block !important
    }
  }

  .visible-print-inline {
    display: none !important
  }

  @media print {
    .visible-print-inline {
      display: inline !important
    }
  }

  .visible-print-inline-block {
    display: none !important
  }

  @media print {
    .visible-print-inline-block {
      display: inline-block !important
    }
  }

  @media print {
    .hidden-print {
      display: none !important
    }
  }

  #error-modal .modal-content {
    padding: 20px;
    color: #af0000;
    font-size: 16px;
    text-align: center
  }

  .link {
    vertical-align: middle;
    font-size: 18px;
    color: #2a91b8;
    transition: color .2s ease-out;
    cursor: pointer
  }

  .link,
  .link:hover {
    text-decoration: none
  }

  .link:hover {
    color: #1e6a87
  }

  .text-green {
    color: #1c9c02
  }

  .text-red {
    color: #af0000
  }

  .divider-helper-2 {
    display: none
  }

  .divider-helper-3 {
    display: block
  }

  @media (max-width:768px) {
    .divider-helper-2 {
      display: block
    }

    .divider-helper-3 {
      display: none
    }
  }

  html body div .btn-green {
    display: block;
    padding: 2px 19px;
    margin: 0;
    height: auto;
    vertical-align: middle;
    font-size: 19px;
    font-weight: 500;
    color: #fff;
    background: linear-gradient(0deg, #50be36, #7ad56a);
    border-radius: 6px;
    border: none
  }

  html body div .btn-green,
  html body div .btn-green:hover {
    transition: opacity .25s, background .25s, linear-gradient .25s
  }

  html body div .btn-green:hover {
    background: linear-gradient(0deg, #3aac34, #56c54b)
  }

  html body div .btn-green:hover:active {
    transition: opacity .25s, background .25s, linear-gradient .25s;
    background: linear-gradient(0deg, #2f8b2a, #49a740)
  }

  html body div .btn-green:disabled {
    opacity: .5;
    cursor: default
  }

  html body div .btn-green:disabled:active,
  html body div .btn-green:disabled:hover {
    background: linear-gradient(0deg, #50be36, #7ad56a)
  }

  .count-wrapper {
    display: inline-block;
    text-align: right
  }

  .count-wrapper .decrement,
  .count-wrapper .increment {
    display: inline-block;
    padding: 0 6px;
    background: none;
    border: none;
    outline: none;
    vertical-align: middle
  }

  .count-wrapper .decrement[disabled] img,
  .count-wrapper .increment[disabled] img {
    -webkit-filter: grayscale(100%)
  }

  .count-wrapper .count {
    display: inline-block;
    padding: 1px;
    height: 25px;
    width: 40px;
    vertical-align: middle;
    text-align: center;
    border-radius: 3px;
    border: 1px solid #c2c2cc
  }

  .count-wrapper .count::-webkit-inner-spin-button,
  .count-wrapper .count::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0
  }

  .count-wrapper .mobile-count-label {
    display: none
  }

  .dialog-wrapper {
    position: fixed;
    display: block;
    z-index: 20;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, .5)
  }

  .dialog-wrapper .dialog-window {
    position: fixed;
    display: block;
    background: #fff;
    border-radius: 5px;
    z-index: 1000000;
    top: 30%;
    left: 50%;
    transform: translate(-50%, -50%)
  }

  .dialog-wrapper .dialog-window.change-spot-dialog {
    max-height: 50%;
    overflow-y: scroll
  }

  .dialog-wrapper .dialog-window .close {
    position: absolute;
    display: block;
    margin: 0;
    padding: 0;
    top: 0;
    right: 0;
    width: 30px;
    height: 30px;
    border: none;
    border-radius: 50%;
    outline: none;
    background: none;
    opacity: .8;
    transition: opacity .2s ease-out
  }

  .dialog-wrapper .dialog-window .close:hover:after,
  .dialog-wrapper .dialog-window .close:hover:before {
    opacity: 1
  }

  .dialog-wrapper .dialog-window .close:after,
  .dialog-wrapper .dialog-window .close:before {
    content: "";
    display: block;
    position: absolute;
    width: 16px;
    height: 2px;
    margin: 0;
    padding: 0;
    top: 14px;
    left: 7px;
    border-radius: 1px;
    background: #000;
    opacity: .8
  }

  .dialog-wrapper .dialog-window .close:after {
    transform: rotate(45deg)
  }

  .dialog-wrapper .dialog-window .close:before {
    transform: rotate(-45deg)
  }

  @media (max-width:450px) {
    .dialog-wrapper .dialog-window {
      width: 90%;
      top: 50%
    }
  }

  .auth-window {
    padding: 30px
  }

  .auth-window .title {
    margin: 0 0 25px;
    font-size: 24px;
    font-weight: 700
  }

  .auth-window .hint {
    margin: 0 0 15px
  }

  .auth-window .btn-auth {
    display: inline-block;
    padding: 3px 0;
    height: 48px;
    width: 120px;
    border-radius: 5px;
    font-size: 32px;
    text-align: center;
    color: #fff;
    background: #507299;
    text-decoration: none;
    transition: background .2s ease-in
  }

  .auth-window .btn-auth.vk {
    background: #507299;
    margin-right: 25px
  }

  .auth-window .btn-auth.vk:hover {
    background: #3d5674
  }

  .auth-window .btn-auth.vk i {
    margin-left: -4px
  }

  .auth-window .btn-auth.fb {
    background: #3b5998;
    font-size: 29px;
    padding-left: 4px;
    float: right
  }

  .auth-window .btn-auth.fb:hover {
    background: #2a406d
  }

  body.fixed-header.editor .cafe-navbar .header-wrapper {
    top: 50px
  }

  body.fixed-header .cafe-navbar {
    min-height: 75px;
    height: 75px
  }

  body.fixed-header .cafe-navbar .header-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    box-shadow: 0 1px 4px 0 rgba(0, 0, 0, .35);
    height: 75px;
    z-index: 1000;
    background: inherit
  }

  body.fixed-header .cafe-navbar .header-wrapper .search .btn-search {
    top: 29px
  }

  body.fixed-header .cafe-navbar .header-wrapper .search .input-search {
    margin-top: 20px
  }

  body.fixed-header .cafe-navbar .header-wrapper .brand,
  body.fixed-header .cafe-navbar .header-wrapper .logo,
  body.fixed-header .cafe-navbar .header-wrapper .logo:before {
    height: 75px
  }

  body.fixed-header .cafe-navbar .header-wrapper .logo img {
    height: 45px
  }

  body.fixed-header .cafe-navbar .header-wrapper .burger-menu-wrapper {
    top: 19px
  }

  body.fixed-header .cafe-navbar .header-wrapper .order {
    margin-top: 27px
  }

  body.fixed-header .cafe-navbar .header-wrapper .order-mobile {
    top: 27px
  }

  body.fixed-header .cafe-navbar .header-wrapper .change-spot .address-wrapper {
    display: none
  }

  .cafe-navbar {
    min-height: 100px;
    font-size: 16px;
    background: #fcf8ef;
    border-bottom: 1px solid #e5e4dc
  }

  .cafe-navbar .main-title {
    display: inline-block;
    font-size: 20px;
    margin: 0 15px 0 0;
    font-weight: 600
  }

  .cafe-navbar .brand {
    margin: 0;
    padding: 0
  }

  .cafe-navbar .brand:after {
    clear: both
  }

  .cafe-navbar .brand .burger-menu-wrapper {
    display: none;
    position: absolute;
    padding: 10px;
    width: 40px;
    height: 40px;
    z-index: 10;
    left: 0;
    top: 42px;
    vertical-align: middle;
    cursor: pointer
  }

  .cafe-navbar .brand .burger-menu-wrapper .burger-menu {
    display: block;
    position: relative;
    width: 20px;
    height: 20px
  }

  .cafe-navbar .brand .logo {
    padding: 0;
    float: none;
    height: auto;
    white-space: nowrap;
    color: #000;
    font-size: 22px;
    font-weight: 400;
    text-decoration: none;
    /*text-overflow:ellipsis;*/
    width: 100%;
    overflow: hidden;
    display: block
  }

  .cafe-navbar .brand .logo:before {
    content: "";
    height: 124px;
    vertical-align: middle;
    display: inline-block
  }

  .cafe-navbar .brand .logo img {
    display: inline;
    object-fit: contain;
    max-width: 135px;
    height: 100px
  }

  .cafe-navbar .brand .order-mobile {
    display: none;
    position: absolute;
    z-index: 10;
    padding: 10px;
    margin: -10px;
    right: 25px;
    top: 52px;
    vertical-align: middle
  }

  .cafe-navbar .brand .order-mobile .show-order {
    text-decoration: none;
    position: relative
  }

  .cafe-navbar .brand .order-mobile .show-order .cart-icon {
    display: inline-block
  }

  .cafe-navbar .brand .order-mobile .show-order .count {
    position: absolute;
    display: inline-block;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    text-align: center;
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    background: red;
    left: 13px;
    top: -5px
  }

  .cafe-navbar .navigation-wrapper {
    background: hsla(0, 0%, 100%, .5);
    border-bottom: 1px solid #e5e4dc
  }

  .cafe-navbar .navigation-wrapper .navigation {
    display: inline-block;
    position: relative
  }

  .cafe-navbar .navigation-wrapper .navigation .pages-list {
    display: inline-block;
    margin: 12px 0;
    padding: 0;
    height: 18px;
    list-style: none
  }

  .cafe-navbar .navigation-wrapper .navigation .pages-list li {
    display: inline-block
  }

  .cafe-navbar .navigation-wrapper .navigation .pages-list li a {
    margin: 0;
    padding: 0;
    color: #000;
    text-decoration: none;
    white-space: nowrap
  }

  .cafe-navbar .navigation-wrapper .navigation .pages-list li:hover a {
    color: #262626
  }

  .cafe-navbar .navigation-wrapper .navigation .pages-list li.active a {
    color: #0f87b2
  }

  .cafe-navbar .navigation-wrapper .navigation .pages-list li:before {
    margin: 0 8px;
    content: "\2022"
  }

  .cafe-navbar .navigation-wrapper .navigation .pages-list :first-child:before {
    margin: 0;
    content: ""
  }

  .cafe-navbar .navigation-wrapper .navigation .extra-menu {
    position: absolute;
    top: 40px;
    right: 0;
    height: 34px;
    width: 34px
  }

  .cafe-navbar .navigation-wrapper .navigation .extra-menu button {
    display: none;
    padding: 5px;
    border: none;
    background: none;
    color: rgba(0, 0, 0, .3);
    font-size: 25px
  }

  .cafe-navbar .navigation-wrapper .navigation .extra-menu button:focus {
    outline: none
  }

  .cafe-navbar .navigation-wrapper .navigation .extra-menu .dropdown-menu {
    transform: translateX(-50%);
    margin-left: 20px;
    text-align: center
  }

  .cafe-navbar .navigation-wrapper .navigation .extra-menu .dropdown-menu:before {
    position: absolute;
    top: -7px;
    left: 50%;
    margin-left: -4px;
    display: inline-block;
    border-right: 7px solid transparent;
    border-bottom: 7px solid rgba(0, 0, 0, .2);
    border-left: 7px solid transparent;
    content: ""
  }

  .cafe-navbar .navigation-wrapper .navigation .extra-menu .dropdown-menu:after {
    position: absolute;
    top: -6px;
    left: 50%;
    margin-left: -3px;
    display: inline-block;
    border-right: 6px solid transparent;
    border-bottom: 6px solid #fff;
    border-left: 6px solid transparent;
    content: ""
  }

  .cafe-navbar .navigation-wrapper .socials {
    display: inline-block;
    padding: 0;
    /*margin:0 0 0 15px;*/
    list-style: none;
    text-align: right
  }

  .cafe-navbar .navigation-wrapper .socials li {
    margin: 7px 10px 5px 0;
    display: inline-block
  }

  .cafe-navbar .navigation-wrapper .socials li:last-child {
    margin-right: 0
  }

  .cafe-navbar .navigation-wrapper .socials li i {
    display: block;
    font-size: 22px;
    color: rgba(0, 0, 0, .35);
    transition: color .4s
  }

  .cafe-navbar .navigation-wrapper .socials li i:hover {
    color: rgba(0, 0, 0, .5)
  }

  .cafe-navbar .search {
    background: #fcf8ef
  }

  .cafe-navbar .search .search-form {
    position: relative
  }

  .cafe-navbar .search .btn-search {
    position: absolute;
    display: block;
    top: 54px;
    left: 26px;
    width: 18px;
    height: 18px;
    border: none;
    padding: 0;
    background: transparent
  }

  .cafe-navbar .search .btn-search .svg {
    width: 18px;
    height: 18px
  }

  .cafe-navbar .search .input-search {
    /*margin-top:45px;*/
    padding-left: 40px;
    height: 34px;
    width: 100%;
    border-radius: 23px;
    border: 1px solid rgba(0, 0, 0, .3);
    outline: none;
    background: #fff;
    transition: box-shadow .2s
  }

  .cafe-navbar .search .input-search:focus {
    box-shadow: 0 0 5px 1px rgba(0, 0, 0, .3)
  }

  .cafe-navbar .order {
    margin-left: -15px;
    font-size: 16px;
    text-align: right;
    margin-top: 51px
  }

  .cafe-navbar .order .show-order {
    text-decoration: none;
    position: relative
  }

  .cafe-navbar .order .show-order .cart-icon {
    display: inline-block;
    width: 21px;
    height: auto;
    vertical-align: middle
  }

  .cafe-navbar .order .show-order .count {
    position: absolute;
    display: block;
    width: 20px;
    height: 20px;
    border: 0;
    border-radius: 50%;
    text-align: center;
    line-height: 20px;
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    background: red;
    left: 13px;
    top: -5px
  }

  .cafe-navbar .order .show-order .text {
    display: inline-block;
    margin-left: 15px;
    height: 20px;
    vertical-align: middle;
    font-size: 17px;
    line-height: 20px;
    color: #50be36
  }

  .cafe-navbar .order .show-order .text .order-sum {
    display: block;
    text-align: left;
    font-size: 15px;
    line-height: 20px;
    color: grey
  }

  .cafe-navbar .change-spot {
    text-align: center
  }

  .cafe-navbar .change-spot .address-wrapper {
    display: block;
    margin-top: 53px;
    color: #333
  }

  .cafe-navbar .change-spot .address-wrapper .pin {
    position: absolute;
    left: 0;
    margin-right: 5px;
    margin-bottom: 5px;
    vertical-align: middle
  }

  .cafe-navbar .change-spot .address-wrapper .address {
    overflow: hidden;
    display: block;
    height: 23px;
    text-overflow: ellipsis;
    margin-left: 0;
    width: 120%;
    white-space: nowrap
  }

  .cafe-navbar .change-spot .change-spot-container {
    padding: 10px 30px;
    margin-right: 1px;
    text-align: left
  }

  .cafe-navbar .change-spot .change-spot-container .change-spot-list {
    padding: 0;
    margin-top: 30px;
    list-style: none;
    font-size: 18px;
    font-weight: 300
  }

  .cafe-navbar .change-spot .change-spot-container .change-spot-list li {
    line-height: 35px;
    margin-top: 10px
  }

  .cafe-navbar .change-spot .change-spot-container .change-spot-list li a {
    padding: 5px 15px
  }

  .cafe-navbar .change-spot .change-spot-container .change-spot-list li a.active {
    color: #000;
    text-decoration: none;
    background-color: #dff7dd;
    border-radius: 15px
  }

  body .cafe-slider {
    height: 440px;
    width: 100%;
    z-index: -1;
    overflow: hidden
  }

  body .cafe-slider .slide {
    z-index: 0;
    position: relative;
    background-position: 50%;
    width: 100%;
    height: 100%;
    min-height: 440px;
    background-size: cover
  }

  body .cafe-slider .slide .slide-inner .slide-header {
    margin-top: 80px;
    font-size: 61px;
    line-height: 68px;
    font-weight: 200;
    color: #fff
  }

  body .cafe-slider .slide .slide-inner .slide-link {
    display: inline-block;
    margin-top: 24px;
    padding: 7px 22px;
    color: #fff;
    font-weight: 100;
    font-size: 22px;
    background: #0082d9;
    border-radius: 2px
  }

  body .cafe-slider .slide .slide-inner .slide-link:hover {
    background: #008ee8;
    text-decoration: none
  }

  body .cafe-slider .slide .slide-inner .slide-link:active {
    background: #0078c8
  }

  .cafe-cart {
    display: none;
    position: absolute;
    z-index: 10000;
    left: 0;
    top: 0;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, .5);
    -webkit-transform: translate(0);
    -webkit-overflow-scrolling: touch
  }

  .cafe-cart .close-cart {
    position: absolute;
    right: 12px;
    top: 50px;
    font-size: 48px;
    font-weight: 400;
    margin: 0;
    line-height: 1;
    height: auto;
    padding: 0 12px;
    background: none;
    border: none;
    outline: none;
    color: #5c5c5c
  }

  .cafe-cart .close-cart.cancel {
    color: #d6453d;
    font-size: 18px;
    top: 90px;
    right: 51px
  }

  .cafe-cart .cart-details,
  .cafe-cart .cart-dish,
  .cafe-cart .cart-edit,
  .cafe-cart .cart-status {
    margin: 50px 0;
    padding: 36px 50px;
    background: #fff;
    border-radius: 7px
  }

  .cafe-cart .cart-edit .title {
    font-size: 25px;
    margin: 0 0 20px;
    font-weight: 700
  }

  .cafe-cart .cart-edit .text-empty-cart {
    text-align: center;
    margin: 20px;
    font-size: 20px
  }

  .cafe-cart .cart-edit .sum-title {
    float: right;
    font-size: 16px;
    line-height: 1;
    margin: 0
  }

  .cafe-cart .cart-edit .cart-dish-modification-label {
    color: #666;
    font-size: 14px
  }

  .cafe-cart .cart-edit .cart-dish-modification-label .edit-dish-modifications {
    cursor: pointer;
    margin-left: 4px;
    color: #438de2;
    border: none;
    white-space: nowrap
  }

  .cafe-cart .cart-edit .ispinner {
    margin: 70px auto 10px
  }

  .cafe-cart .cart-edit .fetch-text {
    text-align: center;
    margin-bottom: 40px
  }

  .cafe-cart .cart-edit .order-item {
    position: relative;
    margin: 15px 0 0
  }

  .cafe-cart .cart-edit .order-item .item-image {
    height: auto;
    margin: 0 auto
  }

  .cafe-cart .cart-edit .order-item .btn-delete-item {
    position: absolute;
    display: inline-block;
    margin: 0;
    padding: 0;
    top: -15px;
    left: 0;
    width: 30px;
    height: 30px;
    font-weight: 400;
    border: none;
    border-radius: 50%;
    box-shadow: 1px 1px 4px 0 #2f94ba;
    outline: none;
    background: #fff;
    color: #2f94ba;
    font-size: 28px;
    line-height: 30px;
    text-align: center
  }

  .cafe-cart .cart-edit .order-item .btn-delete-item:after,
  .cafe-cart .cart-edit .order-item .btn-delete-item:before {
    content: "";
    display: block;
    width: 14px;
    height: 1px;
    background: #3bbae9;
    margin: 0;
    padding: 0;
    position: absolute;
    top: 15px;
    left: 8px
  }

  .cafe-cart .cart-edit .order-item .btn-delete-item:after {
    transform: rotate(45deg)
  }

  .cafe-cart .cart-edit .order-item .btn-delete-item:before {
    transform: rotate(-45deg)
  }

  .cafe-cart .cart-edit .order-item .product-title {
    font-size: 18px;
    line-height: 1;
    margin: 0;
    cursor: pointer
  }

  .cafe-cart .cart-edit .order-item .product-title-mobile {
    display: none;
    margin-left: 15px;
    vertical-align: top;
    font-size: 18px;
    line-height: 1;
    cursor: pointer
  }

  .cafe-cart .cart-edit .order-item .bought-items {
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 16px
  }

  .cafe-cart .cart-edit .order-item .bought-items li {
    margin: 15px 0 0
  }

  .cafe-cart .cart-edit .order-item .bought-items .name {
    display: inline-block;
    margin-right: 15px
  }

  .cafe-cart .cart-edit .order-item .bought-items .price {
    display: inline-block
  }

  .cafe-cart .cart-edit .order-item .bought-items .sum {
    display: inline-block;
    float: right;
    font-weight: 500
  }

  .cafe-cart .cart-edit .order-item .separator {
    margin-top: 15px;
    border-top: 1px dotted grey
  }

  .cafe-cart .cart-edit .continue-shopping-btn {
    display: inline-block;
    position: absolute;
    bottom: 0;
    left: 15px;
    color: #2f94ba;
    font-size: 17px;
    text-decoration: none;
    cursor: pointer
  }

  .cafe-cart .cart-edit .bucket-btn {
    font-size: 25px;
    max-width: 350px;
    min-width: 300px;
    width: 100%;
    padding-top: 7px;
    padding-bottom: 7px;
    height: auto;
    border-radius: 7px;
    border: none
  }

  .cafe-cart .cart-edit .order-totals-wrapper {
    display: inline-block;
    margin-top: 25px;
    text-align: right;
    float: right
  }

  .cafe-cart .cart-edit .order-totals-wrapper .hint {
    text-align: left;
    font-size: 16px;
    margin: 0 0 -10px
  }

  .cafe-cart .cart-edit .order-totals-wrapper .background-square {
    display: inline-block;
    margin-top: 10px;
    text-align: left
  }

  .cafe-cart .cart-edit .order-totals-wrapper .background-square .total-title {
    display: inline-block;
    font-size: 28px;
    font-weight: 500;
    max-width: 300px
  }

  .cafe-cart .cart-edit .order-totals-wrapper .background-square .total-sum {
    display: inline-block;
    float: right;
    font-size: 28px;
    font-weight: 500
  }

  .cafe-cart .cart-edit .order-totals-wrapper .background-square .create-order-btn {
    display: block;
    padding-left: 40px;
    padding-right: 40px;
    font-weight: 500;
    background: #7ad56a;
    color: #fff
  }

  .cafe-cart .cart-details textarea::-webkit-input-placeholder {
    font-size: 15px
  }

  .cafe-cart .cart-details textarea::-moz-placeholder {
    font-size: 15px
  }

  .cafe-cart .cart-details textarea:-ms-input-placeholder {
    font-size: 15px
  }

  .cafe-cart .cart-details textarea:-moz-placeholder {
    font-size: 15px
  }

  .cafe-cart .cart-details .title {
    font-size: 25px;
    margin: 0 0 30px;
    font-weight: 700
  }

  .cafe-cart .cart-details .error-msg {
    font-size: 23px;
    color: red;
    text-align: center;
    margin-bottom: 20px
  }

  .cafe-cart .cart-details .form-group {
    margin-bottom: 0
  }

  .cafe-cart .cart-details .form-group:after {
    content: "";
    display: block;
    clear: both
  }

  .cafe-cart .cart-details .form-group label {
    display: inline-block;
    width: 100%;
    margin: 0;
    vertical-align: top;
    line-height: 34px;
    text-align: right;
    font-size: 20px;
    font-weight: 100;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap
  }

  .cafe-cart .cart-details .form-group .delivery-type,
  .cafe-cart .cart-details .form-group .payment-type,
  .cafe-cart .cart-details .form-group input,
  .cafe-cart .cart-details .form-group select,
  .cafe-cart .cart-details .form-group textarea {
    display: inline-block;
    margin-left: 10px;
    padding: 2px 7px;
    width: 60%;
    vertical-align: top;
    font-size: 20px;
    font-weight: 100;
    box-shadow: none
  }

  .cafe-cart .cart-details .form-group label.no-wrap {
    white-space: normal
  }

  .cafe-cart .cart-details .form-group .spot-address,
  .cafe-cart .cart-details .form-group .spot-name {
    display: inline-block;
    margin: 0 0 0 10px;
    width: 60%;
    vertical-align: top;
    font-size: 20px;
    font-weight: 400;
    text-align: left
  }

  .cafe-cart .cart-details .form-group .delivery-type label,
  .cafe-cart .cart-details .form-group .payment-type label {
    display: block;
    margin-bottom: 5px;
    text-align: left;
    font-weight: 400;
    overflow: initial
  }

  .cafe-cart .cart-details .form-group .delivery-type label input,
  .cafe-cart .cart-details .form-group .payment-type label input {
    display: inline-block;
    vertical-align: middle;
    width: auto;
    height: auto;
    margin: 0 10px 7px 0;
    box-shadow: none
  }

  .cafe-cart .cart-details .form-group .delivery-type .hint,
  .cafe-cart .cart-details .form-group .payment-type .hint {
    word-spacing: normal;
    word-break: normal;
    white-space: normal;
    font-size: 14px;
    line-height: 16px;
    text-align: left;
    display: block;
    width: 100%
  }

  .cafe-cart .cart-details .form-group .label-address2 {
    width: 37%;
    display: inline-block;
    line-height: 1.1;
    white-space: normal
  }

  .cafe-cart .cart-details .form-group .error-field {
    display: block;
    width: 60%;
    height: 20px;
    margin: 5px 0 11px;
    float: right;
    white-space: nowrap;
    overflow: hidden
  }

  .cafe-cart .cart-details .send-order-btn {
    margin-top: 25px;
    margin-left: 40%;
    padding: 7px;
    width: 60%;
    height: auto;
    font-size: 25px;
    color: #fff;
    border-radius: 7px;
    border: none;
    background: #7ad56a
  }

  .cafe-cart .cart-details .ispinner {
    display: block;
    float: right;
    margin-top: -34px;
    margin-right: 18px
  }

  .cafe-cart .cart-details .ispinner.gray .ispinner-blade {
    background: #fff
  }

  .cafe-cart .cart-details .edit-order-btn {
    margin: 10px 0 0 40%;
    width: 60%;
    text-align: center;
    display: block;
    color: #2f94ba;
    font-size: 17px;
    text-decoration: none;
    cursor: pointer
  }

  .cafe-cart .cart-details .complete-order {
    display: block;
    background: #fcf8ef;
    padding: 8px;
    text-align: left
  }

  .cafe-cart .cart-details .complete-order .edit-order {
    display: block;
    cursor: pointer;
    text-align: center;
    margin: 10px 0 0
  }

  .cafe-cart .cart-details .complete-order .total-label,
  .cafe-cart .cart-details .complete-order .total-sum {
    display: inline-block;
    font-size: 15px
  }

  .cafe-cart .cart-details .complete-order .total-sum {
    float: right;
    font-weight: 700
  }

  .cafe-cart .cart-details .complete-order .small-item {
    padding-bottom: 10px;
    margin-bottom: 10px;
    border-bottom: 1px dotted rgba(0, 0, 0, .5)
  }

  .cafe-cart .cart-details .complete-order .small-item .col-xs-5 {
    margin-right: -15px
  }

  .cafe-cart .cart-details .complete-order .small-item .col-xs-7 {
    padding-right: 0
  }

  .cafe-cart .cart-details .complete-order .small-item img {
    display: inline-block;
    width: 100%
  }

  .cafe-cart .cart-details .complete-order .small-item .prod-name {
    display: block;
    color: #2a91b8;
    margin: 0
  }

  .cafe-cart .cart-details .complete-order .small-item .mod-name {
    display: block;
    margin: 10px 0 0
  }

  .cafe-cart .cart-details .complete-order .small-item .cart-dish-modification-label {
    color: #666;
    font-size: 14px
  }

  .cafe-cart .cart-details .complete-order .small-item .count {
    white-space: nowrap;
    font-size: 13px;
    padding: 1px
  }

  .cafe-cart .cart-details .complete-order .small-item .sum {
    float: right;
    white-space: nowrap;
    font-size: 13px
  }

  .cafe-cart .cart-status {
    padding: 60px 100px;
    text-align: center
  }

  .cafe-cart .cart-status .status {
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 5px
  }

  .cafe-cart .cart-status .order-number {
    text-transform: uppercase
  }

  .cafe-cart .cart-status .text {
    font-size: 20px;
    margin: 30px 0 0
  }

  .cafe-cart .cart-status .contacts {
    margin-top: 10px;
    font-size: 20px;
    font-weight: 600
  }

  .cafe-cart .pizzaday-fix {
    width: 40%;
    text-align: right;
    display: inline-block;
    float: left;
    margin-left: -10px
  }

  @media (max-width:767px) {
    .cafe-cart .pizzaday-fix {
      margin-left: 0;
      width: 100%;
      text-align: left
    }

    .cafe-cart .pizzaday-fix br {
      display: none
    }
  }

  .cafe-order-status .cart-status {
    margin: 20px 0;
    background: #fff;
    border-radius: 7px;
    text-align: center
  }

  .cafe-order-status .cart-status .status {
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 5px
  }

  .cafe-order-status .cart-status .order-number {
    text-transform: uppercase
  }

  .cafe-order-status .cart-status .text {
    font-size: 20px;
    margin: 30px 0 0
  }

  .cafe-order-status .cart-status .contacts {
    margin-top: 10px;
    font-size: 20px;
    font-weight: 600
  }

  .cafe-body {
    background: #fff;
    margin-bottom: -100px;
    min-height: 100%
  }

  .cafe-body:after {
    content: "";
    display: block;
    height: 100px
  }

  .cafe-body .left-panel .menu .elem {
    padding-left: 0;
    list-style: none;
    font-size: 16px;
    font-weight: 400;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
  }

  .cafe-body .left-panel .menu .elem li {
    display: flex;
    align-items: center;
    justify-content: center;
    max-width: 350px;
    width: 100%;
    border-radius: 8px;
    min-height: 200px;
    margin: 15px;
    background-color: #fff;
    color: #000;
    text-decoration: none;
    background-repeat: no-repeat;
    background-size: cover;

  }

  .cafe-body .left-panel .menu .elem li:nth-child(1) {
    display: none;
  }

  .cafe-body .left-panel .menu .elem li:nth-child(2) {
    background-image: url(index_files/categories/pizza.jpg);
  }
  .cafe-body .left-panel .menu .elem li:nth-child(3) {
    background-image: url(index_files/categories/seti.jpg);
  }

  .cafe-body .left-panel .menu .elem li:nth-child(4) {
    background-image: url(index_files/categories/holodnie-rolli.jpg);
  }

  .cafe-body .left-panel .menu .elem li:nth-child(5) {
    background-image: url(index_files/categories/jarenie-rolli.jpg);
  }

  .cafe-body .left-panel .menu .elem li:nth-child(6) {
    background-image: url(index_files/categories/zapechenie-rolli.jpg);
  }

  .cafe-body .left-panel .menu .elem li:nth-child(7) {
    background-image: url(index_files/categories/supi.jpg);
  }

  .cafe-body .left-panel .menu .elem li:nth-child(8) {
    background-image: url(index_files/categories/salati.jpg);
  }

  .cafe-body .left-panel .menu .elem li:nth-child(9) {
    background-image: url(index_files/categories/vok.jpg);
  }

  .cafe-body .left-panel .menu .elem li:nth-child(10) {
    background-image: url(index_files/categories/zakuski.jpg);
  }

  .cafe-body .left-panel .menu .elem li:nth-child(11) {
    background-image: url(index_files/categories/sushi.jpg);
  }

  .cafe-body .left-panel .menu .elem li:nth-child(12) {
    background-image: url(index_files/categories/klassic-rolli.jpg);
  }

  .cafe-body .left-panel .menu .elem li:nth-child(13) {
    background-image: url(index_files/categories/napitki.jpg);
  }

  .cafe-body .left-panel .menu .elem li:nth-child(14) {
    background-image: url(index_files/categories/sousi.jpg);
  }

  .cafe-body .left-panel .menu .elem li:nth-child(15) {
    background-image: url(index_files/categories/deserti.jpg);
    background-position: center;
  }

  ..cafe-body .left-panel .menu .elem li a {
    width: 100%;
    height: 100%;
    background-color: #fff;
  }

  .cafe-body .left-panel .menu .elem li.active>a {
    text-decoration: none;
    font-weight: 700
  }

  .cafe-body .left-panel .menu .elem .sub-elem {
    list-style: none
  }

  .cafe-body .left-panel .menu .elem .sub-elem li a {
    display: block;
    margin-left: -10px;
    padding: 12px 0 12px 10px;
    color: grey;
    text-decoration: none
  }

  .cafe-body .left-panel .menu .elem .sub-elem li ul {
    padding-left: 0
  }

  .cafe-body .left-panel .menu .elem .sub-elem li.active>a {
    text-decoration: none;
    font-weight: 700
  }

  .cafe-body .left-panel .contacts {
    font-size: 15px;
    margin-top: 62px
  }

  .cafe-body .left-panel .contacts .title {
    font-size: 15px;
    font-weight: 700;
    margin: 0 0 26px
  }

  .cafe-body .left-panel .contacts p {
    margin: 0;
    line-height: 23px
  }

  .cafe-body .left-panel .map {
    margin: 23px 0;
    border: 0;
    width: 100%;
    height: 240px
  }

  .cafe-body .cat-title {
    /*margin: 0;*/
    float: left;
    font-size: 24px;
    margin-top: 1em;
    margin-bottom: 0;
    /*background-color: #fad877;*/
    background-color: #e8e8e8;
    width: 100%;
    border-radius: 10px;
    padding: .5em 1em;
  }

  .cafe-body .show-all {
    margin: 0 14px 0 0;
    float: right;
    text-decoration: none;
    font-size: 18px;
    color: #2a91b8
  }

  .cafe-body .show-all:hover {
    color: #227797
  }

  .cafe-body .items-section {
    display: block;
    margin-bottom: 30px
  }

  .cafe-body .items-section.highlighted {
    margin: 0 -25px 40px -45px;
    padding: 30px 25px 35px 45px;
    background: #fafafa
  }

  .cafe-body .items-section .cat-title {
    color: #000
  }

  .cafe-body .items-section:after {
    display: block;
    content: "";
    clear: both
  }

  .cafe-body .item-card {
    padding: 10px 15px 10px 10px;
    margin: 20px -10px 0
  }

  .cafe-body .item-card a {
    display: block;
    color: #0f87b2;
    text-decoration: none
  }

  .cafe-body .item-card a:hover {
    color: #20708f
  }

  .cafe-body .item-card .stretchy-wrapper {
    display: block;
    position: relative;
    width: 100%;
    height: 0;
    padding: 65% 0 0;
    overflow: hidden;
    background-position: center;
    background-size: 100%;
    background-repeat: no-repeat;
    border-radius: .5em;
  }

  .cafe-body .item-card .stretchy-wrapper .image {
    display: block;
    position: absolute;
    margin: 0;
    max-width: 100%;
    max-height: 100%;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    object-fit: contain
  }

  .cafe-body .item-card .name {
    font-size: 19px;
    margin: 10px 0 0;
    /* display: inline-block; */
  }

  .cafe-body .item-card .description {
    margin: 10px 0 0;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 19px;
    max-height: 60px;
    font-size: 16px
  }

  .cafe-body .item-card .price {
    display: block;
    margin: 10px 0;
    font-size: 20px;
    font-weight: 600
  }

  .cafe-body .item-card:hover .price {
    margin-bottom: 10px
  }

  .cafe-body .item-card:hover .btn-buy {
    opacity: 1
  }

  .cafe-body .item-card .btn-buy {
    transition: opacity .3s ease-out;
  }

  .cafe-body .item-card .btn-buy .dropdown {
    display: inline-block;
    margin-right: -10px
  }

  .cafe-body .item-card .ended {
    display: block;
    margin-top: -6px;
    color: #f1423d
  }

  .cafe-body .item-card .dropdown .dropdown-menu li {
    cursor: pointer
  }

  .cafe-body .item-card .dropdown .dropdown-menu li .price {
    margin: 0 -7px 0 10px;
    font-size: 14px;
    color: #000;
    float: right
  }

  .cafe-body .item-card .dropdown .dropdown-menu li .ended {
    margin-top: 0
  }

  .cafe-body .about {
    margin-bottom: 64px
  }

  .cafe-body .about h2 {
    margin-bottom: 30px
  }

  .cafe-body .about p {
    line-height: 20px
  }

  .cafe-body .breadcrumb {
    margin-bottom: 30px;
    background: none;
    padding: 0;
    font-size: 16px
  }

  .cafe-body .breadcrumb li a {
    color: #101010;
    text-decoration: none
  }

  .cafe-body .breadcrumb li:hover a {
    color: #000
  }

  .cafe-body .breadcrumb>li+li:before {
    content: "\BB";
    color: #000
  }

  .cafe-footer {
    padding-top: 30px;
    background: #fcf8ef;
    min-height: 100px;
    padding-left: 10px;
    padding-right: 10px;
    font-size: 13px;
    border-top: 1px solid #e5e4dc
  }

  .cafe-footer .pages-list {
    margin: 32px 0 14px;
    padding: 0;
    list-style: none
  }

  .cafe-footer .pages-list li {
    display: inline-block
  }

  .cafe-footer .pages-list li a {
    margin: 0;
    padding: 0;
    color: #000;
    text-decoration: none;
    white-space: nowrap
  }

  .cafe-footer .pages-list li:before {
    margin: 0 8px;
    content: "\2022"
  }

  .cafe-footer .pages-list :first-child:before {
    content: normal;
    margin: 0;
    padding: 0
  }

  .cafe-footer .contacts p {
    margin: 0;
    line-height: 25px
  }

  .cafe-footer .socials {
    margin: 27px 0 0;
    display: block;
    list-style: none;
    padding: 0
  }

  .cafe-footer .socials:last-child {
    margin-right: 0
  }

  .cafe-footer .socials li {
    display: inline-block;
    margin-right: 30px
  }

  .cafe-footer .socials li i {
    display: inline-block;
    font-size: 26px;
    color: rgba(0, 0, 0, .35);
    transition: color .4s
  }

  .cafe-footer .socials li i:hover {
    color: rgba(0, 0, 0, .5)
  }

  .cafe-footer .copyright {
    margin: 20px 0;
    color: rgba(0, 0, 0, .5)
  }

  @media only screen and (max-width:1200px) {

    body .cafe-slider,
    body .cafe-slider div.slide {
      background-repeat: no-repeat;
      background-position: top;
      height: 440px;
      background-size: cover;
      min-height: 0
    }

    body .fotorama__stage {
      height: 440px !important
    }

    body body.fixed-header .cafe-navbar .header-wrapper .change-spot .nav-address {
      margin-top: 27px;
      width: 100%
    }
  }

  @media only screen and (max-width:768px) {

    body .cafe-slider,
    body .cafe-slider div.slide {
      height: 350px
    }

    body .fotorama__stage {
      height: 350px !important
    }

    body .cafe-slider .slide .slide-inner h2.slide-header p {
      font-size: 30px
    }

    body .cafe-slider .slide .slide-inner h2.slide-header {
      line-height: 45px
    }
  }

  @media only screen and (max-width:420px) {

    body .cafe-slider,
    body .cafe-slider div.slide {
      height: 260px
    }

    body .fotorama__stage {
      height: 260px !important
    }

    body .cafe-slider .slide .slide-inner h2.slide-header p {
      font-size: 18px
    }

    body .cafe-slider .slide div.slide-inner {
      padding-left: 10px;
      padding-right: 10px
    }

    body .cafe-slider .slide .slide-inner h2.slide-header {
      line-height: 45px
    }
  }

  @media (min-width:767px) {
    body .mobile-menu {
      display: none !important
    }
  }

  @media (max-width:993px) {
    body .cafe-navbar .navigation-wrapper .socials li {
      margin-right: 2px
    }

    body .cafe-navbar .navigation-wrapper .socials li i {
      font-size: 20px
    }

    body .cafe-navbar .navigation-wrapper .socials:last-child {
      margin-right: 0
    }
  }

  @media (max-width:991px) {

    body .change-spot .nav-address .pin-name,
    body .change-spot .nav-address .pin-name .show-addresses {
      width: 100%
    }

    body .change-spot .nav-address .pin-name .show-addresses span {
      width: 90%
    }
  }

  @media (min-width:992px) {
    body .change-spot {
      padding-left: 20px !important
    }
  }

  @media (max-width:767px) {
    body .cafe-navbar {
      text-align: center
    }

    body .cafe-navbar .main-title {
      margin: 7px 0 -5px
    }

    body .cafe-navbar .navigation-wrapper .navigation,
    body .cafe-navbar .navigation-wrapper .socials {
      text-align: center
    }

    body .cafe-navbar .header-wrapper {
      transition: height .3s ease-out, top .3s ease-out
    }

    body .cafe-navbar .brand {
      transition: all .3s
    }

    body .cafe-navbar .brand .burger-menu-wrapper {
      display: block
    }

    body .cafe-navbar .brand .logo {
      display: inline-block;
      width: 80%;
      margin: 0 10%
    }

    body .cafe-navbar .brand .order-mobile {
      display: block
    }

    body .cafe-navbar .search {
      display: none;
      position: absolute;
      left: 0;
      right: 0;
      z-index: 10000
    }

    body .cafe-navbar .search .btn-search {
      top: 19px;
      left: 9%
    }

    body .cafe-navbar .search .input-search {
      margin: 10px 0;
      width: 90%
    }

    body .cafe-navbar .socials {
      display: block
    }

    body .cafe-navbar .order {
      display: none
    }

    body .cafe-navbar .change-spot .address-wrapper {
      margin-top: -15px
    }

    body .cafe-navbar .change-spot .address-wrapper .pin {
      left: 10px
    }

    body .cafe-navbar .change-spot .address-wrapper .address {
      margin-top: 15px;
      text-align: center;
      width: 100%
    }

    body .cafe-slider,
    body .cafe-slider .slide {
      height: 350px
    }

    body .cafe-slider .slide .slide-inner .slide-header {
      margin-top: 20px;
      font-size: 50px
    }


    body .cafe-body .items-section .item-card.product-card .btn-buy {
      opacity: 1;
      padding: 4px 26px;
      margin: 0
    }

    body .cafe-body .items-section.highlighted {
      padding: 30px 15px 35px;
      margin: 0 -15px
    }

    body .cafe-body .items-section.highlighted .cat img {
      height: auto
    }

    body .cafe-body .about {
      margin-top: 40px
    }

    body .cafe-body .about .contacts {
      margin-top: 20px;
      margin-bottom: 10px
    }

    body .cafe-body .about .contacts .title {
      font-weight: 700
    }

    body .cafe-body .about .map {
      width: 100%;
      height: 300px
    }

    body .cafe-cart {
      background: #fff
    }

    body .cafe-cart .close-cart {
      top: 2px;
      right: 2px
    }

    body .cafe-cart .close-cart.cancel {
      right: 0;
      top: 33px
    }

    body .cafe-cart .cart-edit {
      margin: 0 -15px;
      padding: 36px 15px;
      border-radius: 0
    }

    body .cafe-cart .cart-edit .order-item .item-image {
      display: inline-block;
      width: 100%
    }

    body .cafe-cart .cart-edit .order-item .product-title,
    body .cafe-cart .cart-edit .order-item .sum-title {
      display: none
    }

    body .cafe-cart .cart-edit .order-item .product-title-mobile {
      display: block;
      margin: 10px 0 0
    }

    body .cafe-cart .cart-edit .order-item .bought-items .count-wrapper .decrement,
    body .cafe-cart .cart-edit .order-item .bought-items .count-wrapper .increment,
    body .cafe-cart .cart-edit .order-item .bought-items .price,
    body .cafe-cart .cart-edit .order-item .bought-items .unit-type {
      display: none
    }

    body .cafe-cart .cart-edit .order-item .bought-items .count-wrapper .mobile-count-label {
      display: inline-block;
      font-weight: 400;
      margin-left: 4px
    }

    body .cafe-cart .cart-edit .order-totals-wrapper {
      float: none;
      display: block;
      width: 100%;
      margin: 0
    }

    body .cafe-cart .cart-edit .order-totals-wrapper .background-square {
      display: block;
      margin-top: 15px
    }

    body .cafe-cart .cart-edit .order-totals-wrapper .background-square .create-order-btn {
      display: block;
      max-width: 100%;
      padding-right: 5px;
      padding-left: 5px;
      width: 100%;
      float: none
    }

    body .cafe-cart .cart-edit .continue-shopping-btn {
      float: none;
      position: relative;
      left: 0;
      display: block;
      width: 100%;
      text-align: center;
      margin-top: 20px
    }

    body .cafe-cart .cart-details {
      margin: 0 -15px;
      padding: 36px 15px;
      border-radius: 0
    }

    body .cafe-cart .cart-details .title {
      text-align: center
    }

    body .cafe-cart .cart-details .form-group input,
    body .cafe-cart .cart-details .form-group label,
    body .cafe-cart .cart-details .form-group select,
    body .cafe-cart .cart-details .form-group textarea {
      height: auto;
      text-align: left;
      display: block;
      width: 100%;
      margin-left: 0;
      margin-right: 0
    }

    body .cafe-cart .cart-details .form-group .error-field {
      width: 100%;
      text-align: left;
      margin-left: 10px;
      margin-right: 0
    }

    body .cafe-cart .cart-details .send-order-btn {
      display: block;
      width: 100%;
      margin-right: auto;
      margin-left: auto
    }

    body .cafe-cart .cart-details .edit-order-btn {
      display: inline-block;
      width: 100%;
      margin: 20px 0 0
    }

    body .cafe-cart .cart-details .complete-order {
      display: none
    }

    body .cafe-cart .cart-status {
      padding: 20px
    }

    body .cafe-cart .cart-dish {
      padding: 30px 0;
      margin: 0;
      height: 100%;
      width: 100%
    }

    body .cafe-footer {
      text-align: center
    }

    body .cafe-body .product-page .title {
      margin-top: 20px;
      text-align: center
    }

    body .cafe-body .product-page .center-block {
      text-align: center
    }

    body .cafe-body .product-page .btn-buy {
      max-width: 100%;
      width: 100%
    }

    body .auth-window {
      width: 90%
    }

    body .auth-window .btn-auth {
      width: 100px
    }
  }

  @media (max-width:420px) {

    body .cafe-slider,
    body .cafe-slider .slide {
      height: 260px
    }

    body .cafe-slider .slide .slide-inner {
      padding: 0
    }

    body .cafe-slider .slide .slide-inner .slide-header {
      margin-top: 10px;
      vertical-align: middle;
      font-size: 40px;
      text-align: center
    }

    body .cafe-slider .slide .slide-inner .slide-link {
      display: none
    }

    body .cafe-cart .cart-details .form-group label {
      text-align: left
    }

    body .cafe-cart .cart-details .form-group label .spot-address {
      display: block;
      margin-left: 0
    }

    body .cafe-cart .cart-details .form-group .delivery-type,
    body .cafe-cart .cart-details .form-group .payment-type,
    body .cafe-cart .cart-details .form-group input,
    body .cafe-cart .cart-details .form-group select,
    body .cafe-cart .cart-details .form-group textarea {
      display: block;
      width: 100%;
      margin-left: 0
    }

    body .cafe-cart .cart-details .form-group .delivery-type label,
    body .cafe-cart .cart-details .form-group .payment-type label,
    body .cafe-cart .cart-details .form-group input label,
    body .cafe-cart .cart-details .form-group select label,
    body .cafe-cart .cart-details .form-group textarea label {
      display: block;
      margin-bottom: 5px;
      text-align: left
    }

    body .cafe-cart .cart-details .form-group .delivery-type label input,
    body .cafe-cart .cart-details .form-group .payment-type label input,
    body .cafe-cart .cart-details .form-group input label input,
    body .cafe-cart .cart-details .form-group select label input,
    body .cafe-cart .cart-details .form-group textarea label input {
      margin: 0 10px 0 0
    }

    body .cafe-body .cat-title,
    body .cafe-body .show-all {
      display: block;
      /*margin:0*/
      ;
      text-align: center;
      width: 100%
    }

    body .cafe-body .product-card .description {
      display: none
    }
  }

  .rating-stars {
    text-decoration: none;
    display: inline-block
  }

  .rating-stars .star {
    width: 18px;
    display: inline-block;
    margin-right: 2px;
    vertical-align: middle
  }

  .rating-stars .star polygon {
    transition: fill .12s ease-out
  }

  .rating-stars .star.gray polygon {
    fill: #c4c4c4
  }

  .rating-stars:active,
  .rating-stars:hover,
  .rating-stars:visited {
    text-decoration: none !important
  }

  .rating-stars.editable,
  .rating-stars.editable .star {
    cursor: pointer
  }

  .reviews-statistics {
    display: block;
    margin-top: 25px;
    text-align: left
  }

  .reviews-statistics .avg-rating {
    display: inline-block;
    vertical-align: middle;
    margin: 0 0 3px 2px;
    font-size: 19px;
    font-weight: 400;
    color: #ffd810
  }

  .reviews-statistics .to-reviews {
    display: inline-block;
    vertical-align: middle;
    margin-left: 10px;
    font-size: 18px
  }

  .reviews {
    margin-bottom: 30px
  }

  .reviews h4 {
    margin: 0 0 20px;
    font-size: 24px
  }

  .reviews .rating-description {
    display: inline-block;
    margin-left: 5px;
    font-size: 15px;
    font-weight: 500
  }

  .reviews .new-review {
    margin-bottom: 20px
  }

  .reviews .new-review .comment {
    font-size: 16px;
    margin-top: 5px;
    margin-bottom: 10px
  }

  .reviews .new-review .btn-submit-review {
    padding: 4px 18px
  }

  .reviews .text-result {
    font-size: 18px;
    margin-bottom: 25px
  }

  .reviews .user-review {
    position: relative;
    padding-left: 74px
  }

  .reviews .user-review .avatar {
    position: absolute;
    left: 0;
    top: 0;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover
  }

  .reviews .user-review .name {
    font-size: 20px;
    font-weight: 700;
    margin: 0 0 -2px;
    text-decoration: none;
    transition: color .2s;
    color: #605e5e
  }

  .reviews .user-review .name:hover {
    color: #413f3f
  }

  .reviews .user-review .date {
    font-size: 14px;
    color: #a1a1a1;
    margin-bottom: 10px
  }

  .reviews .user-review .comment {
    font-size: 20px;
    color: #605e5e
  }

  .product-page {
    margin-bottom: 40px
  }

  .product-page .fotorama__nav {
    text-align: left
  }

  .product-page .img-product {
    height: 100%;
    margin: 0
  }

  .product-page .title {
    margin: 0 0 10px;
    font-size: 26px;
    font-weight: 500
  }

  .product-page .modifiers {
    margin: 0 0 25px;
    padding: 0;
    list-style: none
  }

  .product-page .modifiers li {
    position: relative;
    text-align: left;
    margin-bottom: 10px;
    background: #fff;
    padding: 10px 10px 10px 27px;
    border-radius: 4px;
    cursor: pointer
  }

  .product-page .modifiers li .check {
    position: absolute;
    display: none;
    color: #74cef9;
    left: 10px;
    top: 8px
  }

  .product-page .modifiers li.checked {
    display: block;
    box-shadow: 0 0 3px 1px #74cef9
  }

  .product-page .modifiers li.checked .check {
    display: inline
  }

  .product-page .modifiers li:last-child {
    margin-bottom: 0
  }

  .product-page .modifiers li .description {
    display: block;
    margin: 0;
    padding: 0;
    font-size: 17px;
    line-height: 17px;
    color: #777
  }

  .product-page .modifiers li .value {
    position: absolute;
    display: block;
    padding: 0;
    right: 10px;
    bottom: 8px;
    top: auto;
    float: right;
    line-height: 20px;
    font-size: 18px;
    font-weight: 600;
    color: #1c9c02
  }

  .product-page .modifiers li .value.gray {
    color: #777
  }

  .product-page .price {
    display: block;
    margin-bottom: 5px;
    font-size: 18px;
    vertical-align: middle
  }

  .product-page .price b {
    font-weight: 600
  }

  .product-page .stock {
    margin-top: 25px;
    font-size: 18px
  }

  .product-page .stock b {
    font-weight: 600
  }

  .product-page .buy-button-wrapper {
    margin-top: 5px
  }

  .product-page .buy-button-wrapper .sum {
    display: inline-block;
    font-size: 18px
  }

  .product-page .buy-button-wrapper .sum .name {
    font-weight: 600
  }

  .product-page .buy-button-wrapper .count-wrapper {
    float: right
  }

  .product-page .buy-button-wrapper .btn-buy {
    margin: 10px 0 0;
    padding: 7px 5px;
    width: 100%;
    font-size: 22px
  }

  .product-page .hint {
    font-size: 16px
  }

  .product-page .error-msg {
    margin: 15px 0 0;
    color: red
  }

  .product-page .about-product {
    margin-top: 20px
  }

  .product-page .about-product h4 {
    margin: 0 0 15px;
    font-size: 24px;
    float: none
  }

  .product-page .about-product p {
    font-size: 16px;
    margin-top: 19px
  }

  .product-page .about-product :first-child {
    margin-top: 35px
  }

  body,
  html {
    height: 100%
  }

  body {
    font-family: Proxima Nova, Helvetica Neue, Calibri, Helvetica, Arial;
    -webkit-font-smoothing: antialiased;
    font-weight: 400
  }

  body input[type=number]::-webkit-inner-spin-button,
  body input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0
  }

  body input[type=number] {
    -moz-appearance: textfield !important
  }

  .no-scroll {
    overflow: hidden !important
  }

  .burger-menu {
    width: 20px;
    height: 15px;
    transform: rotate(0deg);
    transition: .5s ease-in-out;
    cursor: pointer
  }

  .burger-menu span {
    display: block;
    position: absolute;
    height: 3px;
    width: 100%;
    background: #b1aea8;
    border-radius: 3px;
    opacity: 1;
    left: 0;
    transform: rotate(0deg);
    transition: .25s ease-in-out
  }

  .burger-menu span:first-child {
    top: 0;
    transform-origin: left center
  }

  .burger-menu span:nth-child(2) {
    top: 6px;
    transform-origin: left center
  }

  .burger-menu span:nth-child(3) {
    top: 12px;
    transform-origin: left center
  }

  .burger-menu.open span:first-child {
    transform: rotate(45deg);
    top: -1px;
    left: 0
  }

  .burger-menu.open span:nth-child(2) {
    width: 0;
    opacity: 0
  }

  .burger-menu.open span:nth-child(3) {
    transform: rotate(-45deg);
    top: 13px;
    left: 0
  }

  .mobile-menu {
    width: 100%;
    padding: 0 10px;
    margin-top: 54px;
    font-size: 16px;
    text-align: left;
    overflow-y: scroll
  }

  .mobile-menu ul {
    padding: 0;
    margin: 0;
    list-style: none
  }

  .mobile-menu li {
    padding: 0;
    margin: 0;
    width: 100%
  }

  .mobile-menu li ul {
    display: none
  }

  .mobile-menu span {
    display: block;
    border-bottom: 1px solid #ccc;
    height: auto
  }

  .mobile-menu span:after {
    content: "";
    clear: both
  }

  .mobile-menu .menu-item {
    position: relative
  }

  .mobile-menu a {
    display: block;
    padding: 10px 0;
    margin-right: 45px;
    line-height: 27px;
    font-weight: 400;
    color: #000
  }

  .mobile-menu .btn-left,
  .mobile-menu .btn-right {
    display: inline-block;
    margin-top: 5px;
    padding: 3px 6px;
    border: none;
    color: #ccc;
    outline: none;
    background: none;
    font-size: 23px
  }

  .mobile-menu .btn-left {
    display: none;
    float: left
  }

  .mobile-menu .btn-right {
    position: absolute;
    right: 0;
    top: 0
  }

  .btn-green {
    outline: none;
    border-right: 4px;
    background: #15ad4c;
    font-weight: 700;
    color: #fff
  }

  .btn-green:hover {
    outline: none;
    opacity: .85;
    color: #fff
  }

  .btn-green:active {
    background: #129240
  }

  .btn-green:active,
  .btn-green:focus {
    outline: none;
    color: #fff
  }

  /*# sourceMappingURL=cafe-head.bundle.css.map*/

  body .cafe-navbar {
    background: #FCF8EF;
    border-bottom: 1px solid #e0e0e0;
  }

  body .cafe-navbar .main-title {
    color: #5f5f5f;
  }

  body .cafe-navbar .brand .logo {
    color: #5f5f5f;
  }

  body .cafe-navbar .brand .order-mobile .show-order .count {
    color: #f8f7f0;
    background: red;
  }

  body .cafe-navbar .show-order .cart-icon svg g polyline {
    stroke: #9a4421 !important;
  }

  body .cafe-navbar .show-order .cart-icon svg g path,
  body .cafe-navbar .show-order .cart-icon svg g ellipse {
    fill: #9a4421 !important;
  }

  body .cafe-navbar .show-order .text .order-sum {
    color: #727272;
  }

  body .cafe-navbar .show-order .text .order-sum .icon-rouble {
    color: #727272;
  }

  body .cafe-navbar .order .show-order .text .order-sum {
    color: #5f5f5f;
  }

  body .cafe-navbar .navigation-wrapper,
  body .cafe-navbar .mobile-menu {
    background: #fffff6;
    border-bottom: 1px solid #e0e0e0;
  }

  body .cafe-navbar .navigation-wrapper .navigation .pages-list li,
  body .cafe-navbar .mobile-menu .navigation .pages-list li,
  body .cafe-navbar .navigation-wrapper ul li,
  body .cafe-navbar .mobile-menu ul li {
    color: #5f5f5f;
  }

  body .cafe-navbar .navigation-wrapper .navigation .pages-list li a,
  body .cafe-navbar .mobile-menu .navigation .pages-list li a,
  body .cafe-navbar .navigation-wrapper ul li a,
  body .cafe-navbar .mobile-menu ul li a {
    color: #5f5f5f;
  }

  body .cafe-navbar .navigation-wrapper .navigation .pages-list li:hover a,
  body .cafe-navbar .mobile-menu .navigation .pages-list li:hover a,
  body .cafe-navbar .navigation-wrapper ul li:hover a,
  body .cafe-navbar .mobile-menu ul li:hover a {
    color: #727272;
  }

  body .cafe-navbar .navigation-wrapper .navigation .pages-list li.active a,
  body .cafe-navbar .mobile-menu .navigation .pages-list li.active a,
  body .cafe-navbar .navigation-wrapper ul li.active a,
  body .cafe-navbar .mobile-menu ul li.active a {
    color: #9a4421;
  }

  body .cafe-navbar .navigation-wrapper .socials li i,
  body .cafe-navbar .mobile-menu .socials li i {
    color: #727272;
  }

  body .cafe-navbar .navigation-wrapper .socials li i:hover,
  body .cafe-navbar .mobile-menu .socials li i:hover {
    color: #5f5f5f;
  }

  body .cafe-navbar .change-spot .address-wrapper {
    color: #5f5f5f;
  }

  body .cafe-navbar .search {
    background: #FCF8EF;
  }

  body .cafe-navbar .search .input-search {
    border: 1px solid #e0e0e0;
    background: #f8f7f0;
  }

  body .cafe-navbar .search .input-search:focus {
    box-shadow: 0 0 5px 1px #e0e0e0;
  }

  body .cafe-navbar .order .show-order .count {
    color: #f8f7f0;
    background: red;
  }

  body .cafe-navbar .order .show-order .text {
    color: #9a4421;
  }

  body .cafe-navbar .order .show-order .order-sum {
    color: #181818;
  }

  body .cafe-body {
    background: #f8f7f0;
    color: #151515;
  }

  body .cafe-body .left-panel .menu .elem li a,
  body .cafe-body .left-panel .menu .sub-elem li a {
    color: #FF6807;
  }

  body .cafe-body .left-panel .menu .elem li a {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    border-radius: 8px;
    position: relative;
    z-index: 1;
    padding: 13px 0px;
  }

  .flex--row {
		display: flex;
		justify-content: space-between;
		padding: 1px 0;
		align-items: center;
    height: 105px;
	}

  body .cafe-body .left-panel .menu .elem li a:after {
    content: '';
    width: 70%;
    height: 20%;
    background-color: #fff;
    position: absolute;
    border-radius: 8px;
    left: 50%;
    bottom: 5px;
    transform: translateX(-50%);
    z-index: -1;
  }

  body .cafe-body .left-panel .menu .contacts {
    color: #151515;
  }

  body .cafe-body .show-all {
    color: #9a4421;
  }

  body .cafe-body .show-all:hover {
    color: #b14e26;
  }

  body .cafe-body .items-section {
    color: #151515;
  }

  body .cafe-body .items-section.highlighted {
    background: #f2f1ea;
  }

  body .cafe-body .items-section .cat-title {
    color: #151515;
  }

  body .cafe-body .items-section .item-card a {
    color: #9a4421;
  }

  body .cafe-body .items-section .item-card a:hover {
    color: #b14e26;
  }

  body .cafe-body .items-section .item-card .price {
    color: #FF6807;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  body .cafe-body .items-section .item-card .hide {}

  body .cafe-body .items-section .item-card .select__pizza {
    max-width: 130px;
    max-height: 100px !important;
  }

  body .cafe-body .items-section .item-card .price i {
    color: #151515;
  }

  body .cafe-body .items-section .item-card .description {
    color: #151515;
  }

  body .cafe-body .items-section .item-card .btn-buy {
    color: #f8f7f0;
    background: linear-gradient(to top, #9a4421, #b14e26);
  }

  body .cafe-body .items-section .item-card .dropdown .dropdown-menu li .price {
    color: #151515;
  }

  body .cafe-body .about {
    color: #151515;
  }

  body .cafe-body .about .cat-title {
    color: #151515;
  }

  body .cafe-body .breadcrumb li a {
    color: #151515;
    text-decoration: none;
  }

  body .cafe-body .breadcrumb li:hover a {
    color: #151515;
  }

  body .cafe-body .breadcrumb>li+li:before {
    color: #151515;
  }

  body .cafe-body .product-list-title {
    color: #151515;
  }

  body .cafe-body .product-page .title,
  body .cafe-body .product-page .add-to-cart-wrapper,
  body .cafe-body .product-page .about,
  body .cafe-body .product-page .description,
  body .cafe-body .product-page .stock,
  body .cafe-body .product-page .buy-button-wrapper {
    color: #151515;
  }

  body .cafe-body .product-page .price {
    color: #9a4421;
  }

  body .cafe-body .product-page .modifiers li {
    background: #f8f7f0;
    color: #151515;
  }

  body .cafe-body .product-page .modifiers li .check {
    color: #9a4421;
  }

  body .cafe-body .product-page .modifiers li.checked {
    box-shadow: 0 0 3px 1px #b14e26;
  }

  body .cafe-body .product-page .modifiers li .description {
    color: #181818;
  }

  body .cafe-body .product-page .modifiers li .value {
    color: #9a4421;
  }

  body .cafe-body .product-page .count-wrapper {
    background: #f8f7f0;
  }

  body .cafe-body .product-page .count-wrapper .count {
    border: 1px solid #e0e0e0;
    background: #f8f7f0;
    color: #151515;
  }

  body .cafe-body .product-page .btn-buy {
    background: linear-gradient(to top, #9a4421, #b14e26);
  }

  body .cafe-cart {
    background-color: rgba(0, 0, 0, 0.5);
  }

  body .cafe-cart .close-cart {
    color: #181818;
  }

  body .cafe-cart .cart-edit,
  body .cafe-cart .cart-details,
  body .cafe-cart .cart-status {
    background: #f8f7f0;
  }

  body .cafe-cart .cart-edit .text-empty-cart,
  body .cafe-cart .cart-edit .fetch-text {
    color: #151515;
  }

  body .cafe-cart .cart-edit .title {
    color: #151515;
  }

  body .cafe-cart .cart-edit .order-item .product-title {
    color: #9a4421;
  }

  body .cafe-cart .cart-edit .order-item .sum-title {
    color: #151515;
  }

  body .cafe-cart .cart-edit .order-item .btn-delete-item {
    box-shadow: 1px 1px 4px 0 #9a4421;
    background: #f8f7f0;
    color: #9a4421;
  }

  body .cafe-cart .cart-edit .order-item .btn-delete-item:after,
  body .cafe-cart .cart-edit .order-item .btn-delete-item:before {
    background: #9a4421;
  }

  body .cafe-cart .cart-edit .order-item .bought-items .price,
  body .cafe-cart .cart-edit .order-item .bought-items .sum {
    color: #151515;
  }

  body .cafe-cart .cart-edit .order-item .bought-items .price .icon-rouble,
  body .cafe-cart .cart-edit .order-item .bought-items .sum .icon-rouble {
    color: #151515;
  }

  body .cafe-cart .cart-edit .order-item .bought-items .count-wrapper .count {
    border: 1px solid #e0e0e0;
    background: #f8f7f0;
    color: #151515;
  }

  body .cafe-cart .cart-edit .order-item .separator {
    border-top: 1px dotted #181818;
  }

  body .cafe-cart .cart-edit .continue-shopping-btn {
    color: #9a4421;
  }

  body .cafe-cart .cart-edit .order-totals-wrapper .background-square .total-title,
  body .cafe-cart .cart-edit .order-totals-wrapper .background-square .total-sum {
    color: #151515;
  }

  body .cafe-cart .cart-edit .order-totals-wrapper .background-square .create-order-btn {
    background: #b14e26;
    color: #f8f7f0;
  }

  body .cafe-cart .cart-details {
    color: #151515;
  }

  body .cafe-cart .cart-details .send-order-btn {
    color: #f8f7f0;
    background: #b14e26;
  }

  body .cafe-cart .cart-details .ispinner.gray .ispinner-blade {
    background: #f8f7f0;
  }

  body .cafe-cart .cart-details .edit-order-btn {
    color: #9a4421;
  }

  body .cafe-cart .cart-details .complete-order {
    background: #f2f1ea;
  }

  body .cafe-cart .cart-details .complete-order .small-item {
    border-bottom: 1px dotted #e0e0e0;
  }

  body .cafe-cart .cart-details .complete-order .small-item .prod-name {
    color: #9a4421;
  }

  body .cafe-order-status .cart-status {
    background: #f8f7f0;
  }

  body .reviews .btn-green {
    background: #9a4421;
  }

  body .cafe-footer {
    background: #FCF8EF;
    border-top: 1px solid #e0e0e0;
    color: #151515;
  }

  body .cafe-footer .pages-list li a {
    color: #5f5f5f;
  }

  body .cafe-footer .contacts {
    color: #5f5f5f;
  }

  body .cafe-footer .socials li i {
    color: #727272;
  }

  body .cafe-footer .socials li i:hover {
    color: #5f5f5f;
  }

  body .cafe-footer .copyright {
    color: #5f5f5f;
  }

  body .cafe-footer .copyright a {
    color: #9a4421;
  }


  .item-card p {
    height: 60px;
    overflow: hidden;
  }

  .navigation {
    width: 100%;
  }

  .phone-box {
    float: right;
    padding: 0;
    margin: .4em;
    font-size: 1.5em;
  }

  .phone-box a {
    color: #5f5f5f;
  }

  @media screen and (max-width: 640px) {
    .phone-box {
      width: 100%;
      text-align: center;
      /*margin-top: 0;*/
    }
  }

  .logo img {
    width: 100%;
  }


  .mobile {
    display: none !important
  }

  .desktop {
    display: block
  }

  .hide {
    display: none !important;
  }

  .menu-mob {
    background-color: #FF6807;
    text-align: center;
    padding: 3em;
    position: fixed;
    top: 0;
    bottom: 0;
    left: inherit;
    right: 0;
    height: 100vh;
    z-index: 999;
    overflow: auto;
  }

  .menu-flex {
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    height: 100%;
    font-size: 18px;
  }

  .menu-mob a {
    font-size: 1em;
    display: block;
    margin: .2em;
    text-decoration: none;
    color: #000;
  }

  .menu-mob .logo-img {
    margin-bottom: 2em;
  }

  .menu-mob .btns-social {
    margin-top: 4em;
    font-size: .5em;
  }

  .menu-mob .menu-desc {
    color: #888;
    margin-top: 2em;
  }

  .menu-mob li {
    list-style: none;
    padding: .15em;
  }


  .cart-inp {
    padding: 0 0 .5em 0;
  }

  .cart-inp label {
    margin-top: .5em;
    display: block;
  }

  .cart-inp input {
    margin-bottom: 0;
  }

  .cart-inp textarea {
    margin-top: .3em;
  }

  .items-section .row>div {
    display: inline-block;
    float: none;
    vertical-align: top;
  }
  </style>

</head>

<body class="" style="margin-top: 0px;">
  <!--[CDATA[YII-BLOCK-BODY-BEGIN]]-->

  <!-- <script src="./index_files/272220037785440" async=""></script>
<script async="" src="./index_files/fbevents.js.Без названия"></script>
<script async="" src="./index_files/gtm.js.Без названия"></script>
<script async="" src="./index_files/analytics.js.Без названия"></script> -->

  <!-- Google Tag Manager -->
  <!-- <script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o), m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-42569912-5', 'auto');
    ga('send', 'pageview');
            </script>

<script>(function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-KDJS7B7');</script>
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KDJS7B7"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript> -->
  <!-- End Google Tag Manager -->

  <!--авторизирован пользователь или нет-->



  <nav class="cafe-navbar">
    <!--  <div class="navigation-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="navigation"> -->



    <!--                      <ul class="phone-box">
                        	<a href="tel:8 (937) 771 1838">8 (937) 771 1838</a>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="header-wrapper">
      <div class="container">
        <div class="flex--row">
          <div class="logo--fix">
            <div class="brand">

              <a class="logo navbar-brand" href="/"><img src="./images/head-logo.png" alt="Gurmani" title="Gurmani"></a>

            </div>
          </div>
          <div class=" header-right">
            <div class="brand">

            <div class="mob__social">
              <a href="https://www.instagram.com/gurmani.kzn/"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path xmlns="http://www.w3.org/2000/svg" d="m12.004 5.838c-3.403 0-6.158 2.758-6.158 6.158 0 3.403 2.758 6.158 6.158 6.158 3.403 0 6.158-2.758 6.158-6.158 0-3.403-2.758-6.158-6.158-6.158zm0 10.155c-2.209 0-3.997-1.789-3.997-3.997s1.789-3.997 3.997-3.997 3.997 1.789 3.997 3.997c.001 2.208-1.788 3.997-3.997 3.997z" fill="#ff6807" data-original="#000000" style="" class=""/><path xmlns="http://www.w3.org/2000/svg" d="m16.948.076c-2.208-.103-7.677-.098-9.887 0-1.942.091-3.655.56-5.036 1.941-2.308 2.308-2.013 5.418-2.013 9.979 0 4.668-.26 7.706 2.013 9.979 2.317 2.316 5.472 2.013 9.979 2.013 4.624 0 6.22.003 7.855-.63 2.223-.863 3.901-2.85 4.065-6.419.104-2.209.098-7.677 0-9.887-.198-4.213-2.459-6.768-6.976-6.976zm3.495 20.372c-1.513 1.513-3.612 1.378-8.468 1.378-5 0-7.005.074-8.468-1.393-1.685-1.677-1.38-4.37-1.38-8.453 0-5.525-.567-9.504 4.978-9.788 1.274-.045 1.649-.06 4.856-.06l.045.03c5.329 0 9.51-.558 9.761 4.986.057 1.265.07 1.645.07 4.847-.001 4.942.093 6.959-1.394 8.453z" fill="#ff6807" data-original="#000000" style="" class=""/><circle xmlns="http://www.w3.org/2000/svg" cx="18.406" cy="5.595" r="1.439" fill="#ff6807" data-original="#000000" style="" class=""/></g></svg></a>
              <a href="https://vk.com/gurmanikzn"><svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m19.915 13.028c-.388-.49-.277-.708 0-1.146.005-.005 3.208-4.431 3.538-5.932l.002-.001c.164-.547 0-.949-.793-.949h-2.624c-.668 0-.976.345-1.141.731 0 0-1.336 3.198-3.226 5.271-.61.599-.892.791-1.225.791-.164 0-.419-.192-.419-.739v-5.105c0-.656-.187-.949-.74-.949h-4.126c-.419 0-.668.306-.668.591 0 .622.945.765 1.043 2.515v3.797c0 .832-.151.985-.486.985-.892 0-3.057-3.211-4.34-6.886-.259-.713-.512-1.001-1.185-1.001h-2.625c-.749 0-.9.345-.9.731 0 .682.892 4.073 4.148 8.553 2.17 3.058 5.226 4.715 8.006 4.715 1.671 0 1.875-.368 1.875-1.001 0-2.922-.151-3.198.686-3.198.388 0 1.056.192 2.616 1.667 1.783 1.749 2.076 2.532 3.074 2.532h2.624c.748 0 1.127-.368.909-1.094-.499-1.527-3.871-4.668-4.023-4.878z"/></svg></a>
            </div>
            <p>Режим работы</p>
            <span>10:00–22:00</span>
            </div>
          </div>


      </div>
    </div>
    </div>
  </nav>

  <div class="cafe-cart">
    <div data-reactroot="" class="container">
      <div class="row">
        <div class="col-xs-12 col-md-10 col-md-offset-1"><button class="close-cart false" type="button">×</button>
          <div class="cart-edit">
            <div class="row">
              <div class="col-xs-12">
                <div class="ispinner gray animating undefined">
                  <div class="ispinner-blade"></div>
                  <div class="ispinner-blade"></div>
                  <div class="ispinner-blade"></div>
                  <div class="ispinner-blade"></div>
                  <div class="ispinner-blade"></div>
                  <div class="ispinner-blade"></div>
                  <div class="ispinner-blade"></div>
                  <div class="ispinner-blade"></div>
                  <div class="ispinner-blade"></div>
                  <div class="ispinner-blade"></div>
                  <div class="ispinner-blade"></div>
                  <div class="ispinner-blade"></div>
                  <div class="ispinner-blade"></div>
                </div>
                <p class="fetch-text">Загружаем корзину…</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="add-modifier-wrapper"></div>

  <!-- <header class="cafe-slider">
                <style></style><div class="fotorama--hidden"></div><div class="header-slider-viewport fotorama fotorama1618907866513" data-loop="true" data-autoplay="5000" data-width="100%" data-height="460"><div class="fotorama__wrap fotorama__wrap--css3 fotorama__wrap--slide fotorama__wrap--toggle-arrows" style="width: 100%; min-width: 0px; max-width: 100%;"><div class="fotorama__stage" style="width: 1583px; height: 460px;"><div class="fotorama__stage__shaft" style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px); width: 1583px; margin-left: 0px;"><div class="fotorama__stage__frame fotorama__loaded fotorama__active" style="left: 0px;"><div class="fotorama__html"><div class="slide" data-fit="contain" style="background-image: url(https://img.postershop.me/5935/Slides/19422_1616514363.8329_original.png)"> 
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="slide-inner"> 
                                        <h2 class="slide-header"></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div></div></div></div><div class="fotorama__arr fotorama__arr--prev fotorama__arr--disabled" tabindex="-1" role="button" disabled="disabled" style="display: none;"></div><div class="fotorama__arr fotorama__arr--next fotorama__arr--disabled" tabindex="-1" role="button" disabled="disabled" style="display: none;"></div><div class="fotorama__video-close"></div></div></div></div>
</header> -->


  <?php

// ###################################################
// ### МЕНЮ И КОРЗИНА
// ###################################################
echo '<div class="fix-btns">';
	echo '<div class="btn-menu"></div><br>';
	echo '<div class="btn-cart">';
		echo '<div class="cart-count">0</div>';
		echo '<div class="cart-sum">= 0 р.</div>';
	echo '</div>';
echo '</div>';

echo '<div class="menu-mob hide">';
	echo '<div class="align-center menu-flex">';
		// echo '<div href="/" class="logo-img"></div>';
		// $query_menu = mysqli_query($link, "SELECT * FROM dishes_chapters ORDER BY chapter_num");
		// while($chapter = mysqli_fetch_assoc($query_menu)){
		// 	echo '<a href="/#block-'.$chapter['chapter_id'].'">'.$chapter['chapter_title'].'</a>';
		// };
    echo '<div>';
		echo '<li class="cat-link-wrapper has-sub-cat"><a href="/" itemprop="url">Все категории</a></li>';
		foreach($categories as $category_id => $products_rows){
			echo '<li class="cat-link-wrapper has-sub-cat"><a href="/?category='.$category_id.'" itemprop="url">'.$products_rows[0]['category_name'].'</a></li>';
		}
    echo '</div>';
		// echo '<div class="btns-social">
		// 	<a rel="nofollow" target="_blank" href="https://instagram.com/" class="btn-icon icon-inst"></a>
		// 	<a rel="nofollow" target="_blank" href="https://vk.com/" class="btn-icon icon-vk"></a>
		// </div>';
		// echo '<div class="menu-desc">
		// 	ПН-ЧТ 10:00-21:30<br>
		// 	ПТ 10:00-22:30<br>
		// 	СБ 11:00-22:30<br>
		// 	ВС 11:00-21:30<br>
		// </div>';
    echo '<div class="mob__footer">';
    echo '<div>
      <a href="">Условия доставки</a>
      <a href="">О нас</a>
      <div class="mob__social">
        <a href="https://www.instagram.com/gurmani.kzn/"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path xmlns="http://www.w3.org/2000/svg" d="m12.004 5.838c-3.403 0-6.158 2.758-6.158 6.158 0 3.403 2.758 6.158 6.158 6.158 3.403 0 6.158-2.758 6.158-6.158 0-3.403-2.758-6.158-6.158-6.158zm0 10.155c-2.209 0-3.997-1.789-3.997-3.997s1.789-3.997 3.997-3.997 3.997 1.789 3.997 3.997c.001 2.208-1.788 3.997-3.997 3.997z" fill="#ff6807" data-original="#000000" style="" class=""/><path xmlns="http://www.w3.org/2000/svg" d="m16.948.076c-2.208-.103-7.677-.098-9.887 0-1.942.091-3.655.56-5.036 1.941-2.308 2.308-2.013 5.418-2.013 9.979 0 4.668-.26 7.706 2.013 9.979 2.317 2.316 5.472 2.013 9.979 2.013 4.624 0 6.22.003 7.855-.63 2.223-.863 3.901-2.85 4.065-6.419.104-2.209.098-7.677 0-9.887-.198-4.213-2.459-6.768-6.976-6.976zm3.495 20.372c-1.513 1.513-3.612 1.378-8.468 1.378-5 0-7.005.074-8.468-1.393-1.685-1.677-1.38-4.37-1.38-8.453 0-5.525-.567-9.504 4.978-9.788 1.274-.045 1.649-.06 4.856-.06l.045.03c5.329 0 9.51-.558 9.761 4.986.057 1.265.07 1.645.07 4.847-.001 4.942.093 6.959-1.394 8.453z" fill="#ff6807" data-original="#000000" style="" class=""/><circle xmlns="http://www.w3.org/2000/svg" cx="18.406" cy="5.595" r="1.439" fill="#ff6807" data-original="#000000" style="" class=""/></g></svg></a>
        <a href="https://vk.com/gurmanikzn"><svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m19.915 13.028c-.388-.49-.277-.708 0-1.146.005-.005 3.208-4.431 3.538-5.932l.002-.001c.164-.547 0-.949-.793-.949h-2.624c-.668 0-.976.345-1.141.731 0 0-1.336 3.198-3.226 5.271-.61.599-.892.791-1.225.791-.164 0-.419-.192-.419-.739v-5.105c0-.656-.187-.949-.74-.949h-4.126c-.419 0-.668.306-.668.591 0 .622.945.765 1.043 2.515v3.797c0 .832-.151.985-.486.985-.892 0-3.057-3.211-4.34-6.886-.259-.713-.512-1.001-1.185-1.001h-2.625c-.749 0-.9.345-.9.731 0 .682.892 4.073 4.148 8.553 2.17 3.058 5.226 4.715 8.006 4.715 1.671 0 1.875-.368 1.875-1.001 0-2.922-.151-3.198.686-3.198.388 0 1.056.192 2.616 1.667 1.783 1.749 2.076 2.532 3.074 2.532h2.624c.748 0 1.127-.368.909-1.094-.499-1.527-3.871-4.668-4.023-4.878z"/></svg></a>
      </div>
    </div>';
    echo '<ul class="phone-box">';
    echo '<a href="tel:8 (937) 771 1838">8 (937) 771 1838</a>';
    echo '<span>10:00–22:00</span>';
    echo '<span>
      г. Казань
    </span>';
  echo '</ul>';
  echo '</div>';
	echo '</div>';
			// <br>
			// * прием заказов останавливается<br> за 30 мин. до закрытия
echo '</div>';


// ###################################################
// ### SLIDER
// ###################################################
echo '<div class="block-slider">';
	echo '<div class="slider-left"></div>';
	echo '<div class="slider-right"></div>';

	echo '<div class="sliders-overflow">';
	echo '<div class="sliders">';
		echo '<button  class="slider-promocode" data-promocode="16pm" slider="1" style="background-image: url(images/slider/4.PNG)">';

		echo '</button>';

        echo '<button  class="slider-promocode" data-promocode="WEB" slider="2" style="background-image: url(images/slider/5.PNG)">';

        echo '</button>';

        echo '<button class="slider-promocode" data-promocode="700" slider="3" style="background-image: url(images/slider/6.PNG)">';

        echo '</button>';

	echo '</div>'; // .sliders
	echo '</div>'; // .sliders-overflow

echo '</div>';

?>


  <div class="cafe-body">

    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="left-panel">
            <div class="menu" itemscope="" itemtype="http://schema.org/SiteNavigationElement" role="navigation">
              <ul class="elem caterogies">
                <?php
	                        	echo '<li class="cat-link-wrapper has-sub-cat"><a href="/" itemprop="url">Все категории</a></li>';
	                        	foreach($categories as $category_id => $products_rows){
						    		echo '<li class="cat-link-wrapper has-sub-cat"><a href="/?category='.$category_id.'" itemprop="url">'.$products_rows[0]['category_name'].'</a></li>';
								}
                        	?>
              </ul>
            </div>

            <!--  <div class="map leaflet-container leaflet-touch leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom" id="map" tabindex="0" style="position: relative;"><div class="leaflet-pane leaflet-map-pane" style="transform: translate3d(0px, 0px, 0px);"><div class="leaflet-pane leaflet-tile-pane"><div class="leaflet-layer " style="z-index: 1; opacity: 1;"><div class="leaflet-tile-container leaflet-zoom-animated" style="z-index: 18; transform: translate3d(0px, 0px, 0px) scale(1);"><img alt="" role="presentation" src="./index_files/2559.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(-79px, -10px, 0px); opacity: 1;"><img alt="" role="presentation" src="./index_files/2559(1).png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(177px, -10px, 0px); opacity: 1;"></div></div></div><div class="leaflet-pane leaflet-shadow-pane"><img src="./index_files/marker-shadow.png" class="leaflet-marker-shadow leaflet-zoom-animated" alt="" style="margin-left: -12px; margin-top: -41px; width: 41px; height: 41px; transform: translate3d(126px, 120px, 0px);"></div><div class="leaflet-pane leaflet-overlay-pane"></div><div class="leaflet-pane leaflet-marker-pane"><img src="./index_files/marker-icon.png" class="leaflet-marker-icon leaflet-zoom-animated leaflet-interactive" alt="" tabindex="0" style="margin-left: -12px; margin-top: -41px; width: 25px; height: 41px; transform: translate3d(126px, 120px, 0px); z-index: 120;"></div><div class="leaflet-pane leaflet-tooltip-pane"></div><div class="leaflet-pane leaflet-popup-pane"></div><div class="leaflet-proxy leaflet-zoom-animated" style="transform: translate3d(1.33473e+06px, 655234px, 0px) scale(4096);"></div></div><div class="leaflet-control-container"><div class="leaflet-top leaflet-left"><div class="leaflet-control-zoom leaflet-bar leaflet-control"><a class="leaflet-control-zoom-in" href="/#" title="Zoom in" role="button" aria-label="Zoom in">+</a><a class="leaflet-control-zoom-out" href="/#" title="Zoom out" role="button" aria-label="Zoom out">−</a></div></div><div class="leaflet-top leaflet-right"></div><div class="leaflet-bottom leaflet-left"></div><div class="leaflet-bottom leaflet-right"><div class="leaflet-control-attribution leaflet-control">
                            </div></div></div></div> -->

          </div>
        </div>
        <div class="col-sm-12">


          <!-- <div class="items-section">
        <div class="row">
            <div class="col-xs-12">
                <h2 data-edit-id="bestsellers" class="cat-title">Бестселлеры</h2>
                <a data-edit-id="show_all_link" class="show-all" href="/products/bestsellers">Посмотреть все</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6" data-drag-level="best" data-drag-allowed="true" data-entity-type="product" data-sort-order="147" data-id="1944718">
                <div class="item-card product-card" itemscope="" itemtype="http://schema.org/Product">
                    <span itemprop="name" content="Филадельфия"></span>
                    <div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                        <a href="/zarenye-rolly/filadelfia.html" class="product-url" draggable="false">
                            <div class="stretchy-wrapper">
                                <img class="image product-image" draggable="false" itemprop="image" src="./index_files/1944718_1615629022.2949_original.jpg" data-src="https://img.postershop.me/5935/Products/1944718_1615629022.2949_original.jpg" alt="Филадельфия" title="Филадельфия">
                            </div>
                            <h5 class="name" itemprop="name">Филадельфия</h5>
                        </a>
                        <div class="description" itemprop="description">
                            <div><b>Лосось, сыр, авокадо</b></div><div><i>270 г</i></div>
                        </div>
                        <h5 class="price">
                            <span itemprop="priceCurrency" content="RUB"></span>
                            <span itemprop="price" content="269">269<i class="icon-rouble"></i></span>
                        </h5>

                        <input name="product-data" type="hidden" data-stock="" data-product-id="1944718" data-product-price="269" data-ingredient-id="0" data-unit-type="count">
                        <div class="count-wrapper hide">
                            <input class="count" type="hidden" value="1">
                        </div>
                        <link itemprop="availability" href="http://schema.org/InStock">
                        <button class="btn-green btn-buy action-add-to-cart">Купить</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6" data-drag-level="best" data-drag-allowed="true" data-entity-type="product" data-sort-order="149" data-id="1953295">
                <div class="item-card product-card" itemscope="" itemtype="http://schema.org/Product">
                    <span itemprop="name" content="Пицца Гавайская"></span>
                    <div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                        <a href="/piccy/gavajskaa.html" class="product-url" draggable="false">
                            <div class="stretchy-wrapper">
                                <img class="image product-image" draggable="false" itemprop="image" src="./index_files/1953295_1615559450.9081_original.jpg" data-src="https://img.postershop.me/5935/Products/1953295_1615559450.9081_original.jpg" alt="Пицца Гавайская" title="Пицца Гавайская">
                            </div>
                            <h5 class="name" itemprop="name">Пицца Гавайская</h5>
                        </a>
                        <div class="description" itemprop="description">
                            <div><b>Курица, ананасы, майонез, Моцарелла, карамельный топинг</b></div><div><i>700 гр</i></div>
                        </div>

                        <h5 class="price">
                            <span itemprop="priceCurrency" content="RUB"></span>
                            <span itemprop="price" content="269">269<i class="icon-rouble"></i></span>
                        </h5>

                        <input name="product-data" type="hidden" data-stock="" data-product-id="1944718" data-product-price="269" data-ingredient-id="0" data-unit-type="count">
                        <div class="count-wrapper hide">
                            <input class="count" type="hidden" value="1">
                        </div>
                        <link itemprop="availability" href="http://schema.org/InStock">
                        <button class="btn-green btn-buy action-add-to-cart">Купить</button>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 divider-helper-2"></div>
        </div>

        </div> -->

          <div class="items-section">
            <?php
        		$addons_rolls = Array();
				$query_addons = mysqli_query($link, "SELECT * FROM products WHERE menu_category_id='16'");
				while($row = mysqli_fetch_assoc($query_addons)){
					// foreach($variants as $variant){
					// 	foreach($variant as $v){
					// 		if($row['dish_id']==$v['variant_did']){
					// 			$row['variants'][] = $v;
					// 		}
					// 	}
					// }
					$addons_rolls[] = $row;
				}

	        	if(!$products_categories){
	        		echo '<div class="row">
		                <div class="col-xs-12">
		                	<br><br>
		                    <h2>Блюда не найдены, попробуйте искать иначе</h2>
		                </div>
		                <a name="category-'.$category_id.'"></a>
		        	</div>';
	        	} else {
	        		if($_GET['q'])
		        		echo '<h1 class="product-list-title">Поиск по блюдам "'.$_GET['q'].'"</h1>';
		        	else if(!$_GET['category'])
		        		echo '<h1 class="product-list-title">Все блюда</h1>';
	            	foreach($products_categories as $category_id => $products_rows){
			    		echo '<div class="row">
			                <div class="col-xs-12">
			                    <h2 class="cat-title" data-edit-id="popular_categories">'.$products_rows[0]['category_name'].'</h2>
			                </div>
			                <a name="category-'.$category_id.'"></a>
			        	</div>';
			            echo '<div class="row">';
	                	foreach($products_rows as $row){
	                		echo '<div class="col-md-4 col-sm-4 col-xs-6" data-drag-level="2" data-drag-allowed="true" data-entity-type="category" data-sort-order="1" data-id="191611">

			                    <div class="item-card">
			                        <a class="cart-elem dish-box" dish-fid="'.$row['product_id'].'">
			                            <div class="stretchy-wrapper action-add-to-cart" style="background-image:url('.$row['photo'].')" dish-fid="'.$row['product_id'].'">';
			                                // echo '<img class="image" src="'.$row['photo'].'">';
			                            echo '</div>
			                            <h5 class="name">'.$row['product_name'].'</h5>';

			                            // Для корзины
			                            echo '<meta class="photo" content="'.$row['photo'].'">';

			                            // Данные
			                            echo '<textarea cart-data="product" class="hide">'.json_encode($row).'</textarea>';

			                            // Соуса к роллам
			                            $hasAddons = false;
										// if(in_array($row['menu_category_id'], [5,6,8,7,13])){
										// 	$hasAddons = true;
										// 	// echo 'addons '.$row['menu_category_id'];
										// 	echo '<textarea cart-data="addons_rolls" class="hide">'.json_encode($addons_rolls).'</textarea>';
										// }

			                            if($row['group_modifications']){
			                            	$hasAddons = true;
				                            echo '<textarea cart-data="group_modifications" class="hide">'.$row['group_modifications'].'</textarea>';
			                            }

			                            // if($row['ingredients_list'])
				                           //  echo '<p>'.$row['ingredients_list'].'</p>';

			                            if($row['ingredients_list'])
				                        echo '<div class="description">
					                        <div>'.$row['ingredients_list'].'</div>
				                        </div>';

				                        if($row['out_netto'])
				                        	echo '<div><i>'.round($row['out_netto'],-1).'</i> гр.</div>';

				                        echo '<h5 class="price">
				                            <span itemprop="priceCurrency" class="hide" content="RUB"></span>
				                            <span itemprop="price" content="'.$row['price_shop'].'" class="dish-price">'.$row['price_shop'].' руб.</span>
				                        </h5>

				                        <input name="product-data" type="hidden" data-stock="" data-product-id="1944718" data-product-price="269" data-ingredient-id="0" data-unit-type="count">

				                        <div class="count-wrapper hide">
				                            <input class="count" type="hidden" value="1">
				                        </div>
				                        <link itemprop="availability" href="http://schema.org/InStock">
				                        <button class="button small '.($hasAddons?'action-add-to-cart':'cart-light-add').'">В корзину</button>
			                        
                                </a>
			                    </div>
			                </div>'; // .cart-light-add
				                        // <button class="btn-green btn-buy action-add-to-cart">В корзину</button>
			            }
			            echo '</div>';
	            	}
	            }
            

            	?>
            <!-- <div class="col-md-4 col-sm-4 col-xs-6" data-drag-level="2" data-drag-allowed="true" data-entity-type="category" data-sort-order="1" data-id="191611">
                    <div class="item-card">
                        <a href="/piccy">
                            <div class="stretchy-wrapper">
                                <img class="image" src="./index_files/191611_1611940799.3352_original.jpeg" data-src="https://img.postershop.me/5935/Categories/191611_1611940799.3352_original.jpeg" alt="Пиццы" title="Пиццы">
                            </div>
                            <h5 class="name">Пиццы</h5>

	                        <h5 class="price">
	                            <span itemprop="priceCurrency" content="RUB"></span>
	                            <span itemprop="price" content="269">269<i class="icon-rouble"></i></span>
	                        </h5>

	                        <input name="product-data" type="hidden" data-stock="" data-product-id="1944718" data-product-price="269" data-ingredient-id="0" data-unit-type="count">
	                        <div class="count-wrapper hide">
	                            <input class="count" type="hidden" value="1">
	                        </div>
	                        <link itemprop="availability" href="http://schema.org/InStock">
	                        <button class="btn-green btn-buy action-add-to-cart">Купить</button>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6" data-drag-level="2" data-drag-allowed="true" data-entity-type="category" data-sort-order="2" data-id="191736">
                    <div class="item-card">
                        <a href="/holodnye-rolly">
                            <div class="stretchy-wrapper">
                                <img class="image" src="./index_files/191736_1612172263.0628_original.jpg" data-src="https://img.postershop.me/5935/Categories/191736_1612172263.0628_original.jpg" alt="Сеты" title="Сеты">
                            </div>
                            <h5 class="name">Сеты</h5>

                            <h5 class="price">
	                            <span itemprop="priceCurrency" content="RUB"></span>
	                            <span itemprop="price" content="269">269<i class="icon-rouble"></i></span>
	                        </h5>

	                        <input name="product-data" type="hidden" data-stock="" data-product-id="1944718" data-product-price="269" data-ingredient-id="0" data-unit-type="count">
	                        <div class="count-wrapper hide">
	                            <input class="count" type="hidden" value="1">
	                        </div>
	                        <link itemprop="availability" href="http://schema.org/InStock">
	                        <button class="btn-green btn-buy action-add-to-cart">Купить</button>
                        </a>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 divider-helper-2"></div>
                <div class="col-md-4 col-sm-4 col-xs-6" data-drag-level="2" data-drag-allowed="true" data-entity-type="category" data-sort-order="3" data-id="191737">
                    <div class="item-card">
                        <a href="/zarenye-rolly">
                            <div class="stretchy-wrapper">
                                <img class="image" src="./index_files/191737_1612194148.1299_original.jpeg" data-src="https://img.postershop.me/5935/Categories/191737_1612194148.1299_original.jpeg" alt="Холодные роллы" title="Холодные роллы">
                            </div>
                            <h5 class="name">Холодные роллы</h5>
                        </a>
                    </div>
                </div>
            	<div class="col-xs-12 divider-helper-3"></div> -->
            <!-- </div> -->
          </div>
          <div class="about quote">
            <!-- <div class="row">
                <div class="col-xs-12">
                    <h2 class="cat-title">О нас</h2>
                </div>
            </div> -->
            <p>
              Нам удалось создать достойный продукт, в котором мы уверены на 100%. Мы отвечаем за высокое качество
              каждого ингредиента и скорость доставки.
            </p>
            <p>
              Наша цель радовать вас, доставляя вкусную еду. Приносить удовольствие и впечатления.
            </p>
          </div>

        </div>
      </div>

    </div>
    </>
    <div class="container">
      <div class="contacts">
        <div class="contacts__info">
          <h2 class="contacts__title">Наши координаты</h2>
          <p class="contacts__subtitle">г. Казань, ул. Оренбургский тракт, 8В</p>
          <p class="contacts__subtitle">8 (937) 771 1838</p>
          <p class="contacts__subtitle">
            Принимаем к оплате

            <svg width="50" height="32" viewBox="0 0 45 27" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M45 13.5C45 20.9077 38.9769 27 31.5 27C24.0923 27 18 20.9077 18 13.5C18 6.09231 24.0231 0 31.4308 0C38.9769 0 45 6.09231 45 13.5Z"
                fill="#F9B50B" />
              <path
                d="M26.9308 13.5692C26.9308 12.6 26.7923 11.6308 26.6538 10.7308H18.3462C18.4154 10.2462 18.5538 9.83077 18.6923 9.27692H26.1C25.9615 8.79231 25.7538 8.30769 25.5462 7.82308H19.2462C19.4538 7.33846 19.7308 6.92308 20.0077 6.36923H24.7846C24.5077 5.88462 24.1615 5.4 23.7462 4.91538H21.1154C21.5308 4.43077 21.9462 4.01538 22.5 3.53077C20.1462 1.31538 16.9615 0 13.4308 0C6.09231 0.207692 0 6.09231 0 13.5C0 20.9077 6.02308 27 13.5 27C17.0308 27 20.1462 25.6154 22.5692 23.4692C23.0538 23.0538 23.4692 22.5692 23.9538 22.0154H21.1846C20.8385 21.6 20.4923 21.1154 20.2154 20.6308H24.9231C25.2 20.2154 25.4769 19.7308 25.6846 19.1769H19.3846C19.1769 18.7615 18.9692 18.2769 18.8308 17.7231H26.2385C26.6538 16.4769 26.9308 15.0923 26.9308 13.5692Z"
                fill="#C8191C" />
              <path
                d="M18.2769 16.9615L18.4846 15.7154C18.4154 15.7154 18.2769 15.7846 18.1385 15.7846C17.6538 15.7846 17.5846 15.5077 17.6538 15.3692L18.0692 12.8769H18.8308L19.0385 11.4923H18.3462L18.4846 10.6615H17.0308C17.0308 10.6615 16.2 15.3692 16.2 15.9231C16.2 16.7538 16.6846 17.1692 17.3769 17.1692C17.7923 17.1692 18.1385 17.0308 18.2769 16.9615Z"
                fill="white" />
              <path
                d="M18.7615 14.6769C18.7615 16.6846 20.1462 17.1692 21.2538 17.1692C22.2923 17.1692 22.7769 16.9615 22.7769 16.9615L23.0538 15.5769C23.0538 15.5769 22.2923 15.9231 21.5308 15.9231C19.9385 15.9231 20.2154 14.7462 20.2154 14.7462H23.1231C23.1231 14.7462 23.3308 13.8462 23.3308 13.4308C23.3308 12.5308 22.8462 11.3538 21.2538 11.3538C19.8692 11.2846 18.7615 12.8769 18.7615 14.6769ZM21.2538 12.6C22.0154 12.6 21.8769 13.5 21.8769 13.5692H20.2846C20.3538 13.5 20.4923 12.6 21.2538 12.6Z"
                fill="white" />
              <path
                d="M30.3231 16.9615L30.6 15.3692C30.6 15.3692 29.9077 15.7154 29.3538 15.7154C28.3846 15.7154 27.9 14.9538 27.9 14.0538C27.9 12.3231 28.7308 11.4231 29.7692 11.4231C30.4615 11.4231 31.0846 11.8385 31.0846 11.8385L31.2923 10.3154C31.2923 10.3154 30.4615 9.96922 29.6308 9.96922C27.9692 9.96922 26.3769 11.4231 26.3769 14.1231C26.3769 15.9231 27.2077 17.1 28.9385 17.1C29.5615 17.1692 30.3231 16.9615 30.3231 16.9615Z"
                fill="white" />
              <path
                d="M10.4538 11.2846C9.48461 11.2846 8.72308 11.5615 8.72308 11.5615L8.51538 12.8077C8.51538 12.8077 9.13846 12.5308 10.1077 12.5308C10.5923 12.5308 11.0077 12.6 11.0077 13.0154C11.0077 13.2923 10.9385 13.3615 10.9385 13.3615H10.3154C9.06923 13.3615 7.75385 13.8462 7.75385 15.5077C7.75385 16.8231 8.58461 17.1 9.13846 17.1C10.1077 17.1 10.5923 16.4769 10.6615 16.4769L10.5923 17.0308H11.7692L12.3231 13.0846C12.3231 11.3539 10.9385 11.2846 10.4538 11.2846ZM10.7308 14.4692C10.7308 14.6769 10.5923 15.8539 9.76154 15.8539C9.34615 15.8539 9.20769 15.5077 9.20769 15.3C9.20769 14.9539 9.41538 14.4692 10.5231 14.4692C10.6615 14.4692 10.7308 14.4692 10.7308 14.4692Z"
                fill="white" />
              <path
                d="M13.7077 17.1C14.0539 17.1 15.8539 17.1692 15.8539 15.2308C15.8539 13.4308 14.1231 13.7769 14.1231 13.0846C14.1231 12.7385 14.4 12.6 14.8846 12.6C15.0923 12.6 15.8539 12.6692 15.8539 12.6692L16.0615 11.3538C16.0615 11.3538 15.5769 11.2154 14.6769 11.2154C13.6385 11.2154 12.5308 11.6308 12.5308 13.0846C12.5308 14.7461 14.3308 14.6077 14.3308 15.2308C14.3308 15.6461 13.8462 15.7154 13.5 15.7154C12.8769 15.7154 12.1846 15.5077 12.1846 15.5077L11.9769 16.8231C12.1154 16.9615 12.5308 17.1 13.7077 17.1Z"
                fill="white" />
              <path
                d="M42.2308 10.1769L41.9538 12.1154C41.9538 12.1154 41.4 11.4231 40.5692 11.4231C39.2538 11.4231 38.1461 13.0154 38.1461 14.8846C38.1461 16.0615 38.7 17.2385 39.9462 17.2385C40.7769 17.2385 41.3308 16.6846 41.3308 16.6846L41.2615 17.1692H42.7154L43.7538 10.3154L42.2308 10.1769ZM41.5385 13.9154C41.5385 14.6769 41.1923 15.7154 40.3615 15.7154C39.8769 15.7154 39.6 15.3 39.6 14.5385C39.6 13.3615 40.0846 12.6692 40.7769 12.6692C41.2615 12.7385 41.5385 13.0846 41.5385 13.9154Z"
                fill="white" />
              <path
                d="M2.63077 17.0308L3.46154 11.9077L3.6 17.0308H4.56923L6.43846 11.9077L5.67692 17.0308H7.2L8.37692 10.1769H6.02308L4.56923 14.4L4.5 10.1769H2.42308L1.24615 17.0308H2.63077Z"
                fill="white" />
              <path
                d="M24.7846 17.0308C25.2 14.6769 25.2692 12.7385 26.3077 13.0846C26.4462 12.1846 26.6538 11.7692 26.7923 11.4231H26.5154C25.8923 11.4231 25.3385 12.2539 25.3385 12.2539L25.4769 11.4923H24.0923L23.1923 17.0308H24.7846V17.0308Z"
                fill="white" />
              <path
                d="M33.6461 11.2846C32.6769 11.2846 31.9154 11.5615 31.9154 11.5615L31.7077 12.8077C31.7077 12.8077 32.3308 12.5308 33.3 12.5308C33.7846 12.5308 34.2 12.6 34.2 13.0154C34.2 13.2923 34.1308 13.3615 34.1308 13.3615H33.5077C32.2615 13.3615 30.9462 13.8462 30.9462 15.5077C30.9462 16.8231 31.7769 17.1 32.3308 17.1C33.3 17.1 33.7846 16.4769 33.8538 16.4769L33.7846 17.0308H35.1L35.6538 13.0846C35.6538 11.3539 34.1308 11.2846 33.6461 11.2846ZM33.9923 14.4692C33.9923 14.6769 33.8538 15.8539 33.0231 15.8539C32.6077 15.8539 32.4692 15.5077 32.4692 15.3C32.4692 14.9539 32.6769 14.4692 33.7846 14.4692C33.9231 14.4692 33.9231 14.4692 33.9923 14.4692Z"
                fill="white" />
              <path
                d="M36.7615 17.0308C37.1769 14.6769 37.2462 12.7385 38.2846 13.0846C38.4231 12.1846 38.6308 11.7692 38.7692 11.4231H38.4923C37.8692 11.4231 37.3154 12.2539 37.3154 12.2539L37.4539 11.4923H36.0692L35.1692 17.0308H36.7615V17.0308Z"
                fill="white" />
            </svg>


            <svg width="69" height="21" viewBox="0 0 69 21" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M63.8 0.299999H59.5C58.2 0.299999 57.2 0.699999 56.6 2L48.4 20.7H54.2C54.2 20.7 55.2 18.2 55.4 17.6C56 17.6 61.7 17.6 62.5 17.6C62.7 18.3 63.2 20.6 63.2 20.6H68.4L63.8 0.299999ZM57 13.4C57.5 12.2 59.2 7.7 59.2 7.7C59.2 7.8 59.7 6.5 59.9 5.8L60.3 7.6C60.3 7.6 61.4 12.5 61.6 13.5H57V13.4Z"
                fill="#3362AB" />
              <path
                d="M48.8 14C48.8 18.2 45 21 39.1 21C36.6 21 34.2 20.5 32.9 19.9L33.7 15.3L34.4 15.6C36.2 16.4 37.4 16.7 39.6 16.7C41.2 16.7 42.9 16.1 42.9 14.7C42.9 13.8 42.2 13.2 40 12.2C37.9 11.2 35.1 9.6 35.1 6.7C35.1 2.7 39 0 44.5 0C46.6 0 48.4 0.4 49.5 0.9L48.7 5.3L48.3 4.9C47.3 4.5 46 4.1 44.1 4.1C42 4.2 41 5.1 41 5.9C41 6.8 42.2 7.5 44.1 8.4C47.3 9.9 48.8 11.6 48.8 14Z"
                fill="#3362AB" />
              <path
                d="M0 0.499999L0.1 0.0999985H8.7C9.9 0.0999985 10.8 0.499998 11.1 1.8L13 10.8C11.1 6 6.7 2.1 0 0.499999Z"
                fill="#F9B50B" />
              <path
                d="M25.1 0.300001L16.4 20.6H10.5L5.5 3.6C9.1 5.9 12.1 9.5 13.2 12L13.8 14.1L19.2 0.200001H25.1V0.300001Z"
                fill="#3362AB" />
              <path d="M27.4 0.200001H32.9L29.4 20.6H23.9L27.4 0.200001Z" fill="#3362AB" />
            </svg>

          </p>
          <div class="contacts__social">
            <a target="_blank" href="https://www.instagram.com/gurmani.kzn/"><svg xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1"
                width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512"
                xml:space="preserve" class="">
                <g>
                  <path xmlns="http://www.w3.org/2000/svg"
                    d="m12.004 5.838c-3.403 0-6.158 2.758-6.158 6.158 0 3.403 2.758 6.158 6.158 6.158 3.403 0 6.158-2.758 6.158-6.158 0-3.403-2.758-6.158-6.158-6.158zm0 10.155c-2.209 0-3.997-1.789-3.997-3.997s1.789-3.997 3.997-3.997 3.997 1.789 3.997 3.997c.001 2.208-1.788 3.997-3.997 3.997z"
                    fill="#ff6807" data-original="#000000" style="" class="" />
                  <path xmlns="http://www.w3.org/2000/svg"
                    d="m16.948.076c-2.208-.103-7.677-.098-9.887 0-1.942.091-3.655.56-5.036 1.941-2.308 2.308-2.013 5.418-2.013 9.979 0 4.668-.26 7.706 2.013 9.979 2.317 2.316 5.472 2.013 9.979 2.013 4.624 0 6.22.003 7.855-.63 2.223-.863 3.901-2.85 4.065-6.419.104-2.209.098-7.677 0-9.887-.198-4.213-2.459-6.768-6.976-6.976zm3.495 20.372c-1.513 1.513-3.612 1.378-8.468 1.378-5 0-7.005.074-8.468-1.393-1.685-1.677-1.38-4.37-1.38-8.453 0-5.525-.567-9.504 4.978-9.788 1.274-.045 1.649-.06 4.856-.06l.045.03c5.329 0 9.51-.558 9.761 4.986.057 1.265.07 1.645.07 4.847-.001 4.942.093 6.959-1.394 8.453z"
                    fill="#ff6807" data-original="#000000" style="" class="" />
                  <circle xmlns="http://www.w3.org/2000/svg" cx="18.406" cy="5.595" r="1.439" fill="#ff6807"
                    data-original="#000000" style="" class="" />
                </g>
              </svg></a>
            <a target="_blank" href="https://vk.com/gurmanikzn"><svg id="Bold" enable-background="new 0 0 24 24"
                height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="m19.915 13.028c-.388-.49-.277-.708 0-1.146.005-.005 3.208-4.431 3.538-5.932l.002-.001c.164-.547 0-.949-.793-.949h-2.624c-.668 0-.976.345-1.141.731 0 0-1.336 3.198-3.226 5.271-.61.599-.892.791-1.225.791-.164 0-.419-.192-.419-.739v-5.105c0-.656-.187-.949-.74-.949h-4.126c-.419 0-.668.306-.668.591 0 .622.945.765 1.043 2.515v3.797c0 .832-.151.985-.486.985-.892 0-3.057-3.211-4.34-6.886-.259-.713-.512-1.001-1.185-1.001h-2.625c-.749 0-.9.345-.9.731 0 .682.892 4.073 4.148 8.553 2.17 3.058 5.226 4.715 8.006 4.715 1.671 0 1.875-.368 1.875-1.001 0-2.922-.151-3.198.686-3.198.388 0 1.056.192 2.616 1.667 1.783 1.749 2.076 2.532 3.074 2.532h2.624c.748 0 1.127-.368.909-1.094-.499-1.527-3.871-4.668-4.023-4.878z" />
              </svg></a>
          </div>
        </div>
        <div class="contacts__map">
          <iframe class="yandex__map"
            src="https://yandex.ru/map-widget/v1/?um=constructor%3A461e470d942e41b0e289aaa3d688ddd1b8e5284f5d19b64c6c51ee6ee0b6cc60&amp;source=constructor"
            frameborder="0"></iframe>
        </div>
      </div>
    </div>
    <!-- Необходим для вывода модальных сообщений -->
    <!-- <div id="error-modal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content"></div>
    </div>
</div> -->

    <div class="time-warning">
      <img src="images/head-logo.png" alt="">
      <p>К сожалению мы уже закрыты
        Работаем ежедневно с 10.00 до 22.00
        Вы можете сделать предзаказ на завтра</p>
      <span>с 10:00 до 22:00</span>
      <button class="close__button">Сделать предзаказ</button>
    </div>
    <div class="time-overlay">
    </div>

    <footer class="cafe-footer">
      <div class="container">
        <div class="row flex-row">
          <div>
            <!-- <ul class="pages-list"><li><a href="/page/oplata-i-dostavka">Оплата и доставка</a></li></ul>                 -->
            <div class="footer__contacts">
              <div>
                <br>
              </div>
              <b>8 (937) 771 1838</b><br>
              <b>gurmanikzn@mail.ru</b>
              <br><br>
              <a href="https://vk.com/gurmanikzn"><img src="images/vk.png" width="32"></a>
              <a href="https://www.instagram.com/gurmani.kzn"><img src="images/insta.png" width="32"></a>
              <br><br>
              <iframe src="https://yandex.ru/sprav/widget/rating-badge/163595445939" width="150" height="50"
                frameborder="0"></iframe>
            </div>
          </div>
          <div class="">
            <p class="copyright">2021 GURMANI ИП КОРНИЛОВ А. А. ИНН: 503614560405 ОГРН: 321169000049507</p>
          </div>
          <div class="footer__info">
            <a href="">Меню, </a>
            <a href="delivery.php">Доставка, </a>
            <a href="privacy-policy.php">Политика конфедициальности</a>
            <a href="">Условия оплаты</a>
          </div>
        </div>
      </div>

    </footer>

    <!--CSS -->

    <!-- <link type="text/css" rel="stylesheet" href="./index_files/cafe.bundle.css"> -->

    <!--JS-->
    <!-- <script>window.props = {"shopStock":{"check_leftovers":"false","show_leftovers":"false"},"currency":{"currency_id":9,"pos_id":2,"name":"Российский рубль","code":"руб.","symbol":"<i class=\"icon-rouble\"></i>","iso_code":"RUB","iso_number":"643"},"domain":"postershop.me","tariff":"shop","minOrderAmount":"500","canShowAddress2":"1","mapMarkers":"[{\"lat\":\"55.78874\",\"lng\":\"49.12214\"}]","yalta":false,"nickel":false,"showChangeSpots":false,"isEU":false};</script> -->


    <!-- <script async="" src="./index_files/cafe.bundle.js.Без названия"></script> -->



    <link rel="stylesheet" href="./index_files/leaflet.css"
      integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
      crossorigin="">

    <!-- <script src="./index_files/leaflet.js.Без названия" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA==" crossorigin="" onload="window.initMap &amp;&amp; initMap()"></script> -->


    <!-- <script type="text/javascript" id="">!function(b,e,f,g,a,c,d){b.fbq||(a=b.fbq=function(){a.callMethod?a.callMethod.apply(a,arguments):a.queue.push(arguments)},b._fbq||(b._fbq=a),a.push=a,a.loaded=!0,a.version="2.0",a.queue=[],c=e.createElement(f),c.async=!0,c.src=g,d=e.getElementsByTagName(f)[0],d.parentNode.insertBefore(c,d))}(window,document,"script","https://connect.facebook.net/en_US/fbevents.js");fbq("init","272220037785440");fbq("set","agent","tmgoogletagmanager","272220037785440");fbq("track","PageView");</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=272220037785440&amp;ev=PageView&amp;noscript=1"></noscript> -->

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
    (function(m, e, t, r, i, k, a) {
      m[i] = m[i] || function() {
        (m[i].a = m[i].a || []).push(arguments)
      };
      m[i].l = 1 * new Date();
      k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k,
        a)
    })
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(79488682, "init", {
      clickmap: true,
      trackLinks: true,
      accurateTrackBounce: true,
      webvisor: true
    });
    </script>
    <noscript>
      <div><img src="https://mc.yandex.ru/watch/79488682" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->



    <script src="script/jquery.js"></script>
    <script src="script/jquery-ui.js"></script>
    <script src="script/jquery.cookie.js"></script>
    <script src="script/streets.js<?php echo '?'.$hash ?>"></script>
    <script src="script/main.js<?php echo '?'.$hash ?>"></script>


</body>

</html>