<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Boxes";
$page = "box";
$tab = "4";
$return = "box.php";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$orderby = ( $_GET['orderby'] );
if ( empty( $orderby ) )
{
    $orderby = "boxid";
}
$dir = ( $_GET['dir'] );
if ( empty( $dir ) )
{
    $dirImage = " <img src='templates/".TEMPLATE."/images/asc.png' align='bottom' alt='' />";
}
else if ( $dir = "desc" )
{
    $dirImage = " <img src='templates/".TEMPLATE."/images/desc.png' align='bottom' alt='' />";
}
$search = ( $_GET['search'] );
$q = ( $_GET['q'] );
if ( !empty( $q ) )
{
    $linkend .= "&amp;search=".$search."&amp;q=".$q;
}
if ( !empty( $_GET['rows'] ) && ( $_GET['rows'] ) )
{
    $rowsperpage = ( $_GET['rows'] );
    $linkend .= "&amp;rows=".( $_GET['rows'] );
}
else if ( !empty( $_COOKIE['boxrows'] ) && ( $_COOKIE['boxrows'] ) )
{
    $rowsperpage = ( $_COOKIE['boxrows'] );
}
else if ( $_GET['rows'] == "All" || $_COOKIE['boxrows'] == "All" )
{
    $rowsperpage = 999999;
}
else
{
    $rowsperpage = 15;
}
$pagenum = ( $_GET['page'] );
if ( empty( $pagenum ) )
{
    $limit = 0;
    $pagenum = 1;
}
else
{
    $limit = --$pagenum * $rowsperpage;
    ++$pagenum;
    $linkend .= "&amp;page=".$pagenum;
}
$query = "SELECT * FROM `box` ";
if ( !empty( $q ) )
{
    $query .= "WHERE `".$search."` LIKE '%".$q."%' ";
}
$query .= "ORDER BY `".$orderby."` ";
if ( !empty( $dir ) )
{
    $query .= $dir." ";
}
$numrecords = ( $query );
$numpages = ( $numrecords / $rowsperpage );
$result = ( $query."LIMIT ".$limit.", ".$rowsperpage );
$rows1 = ( "SELECT * FROM `config` WHERE `setting` = 'lastcronrun' LIMIT 1" );
include( "./templates/".TEMPLATE."/header.php" );
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\">\r\n  <tr>\r\n    <td width=\"5\" class=\"tabspacer\"><img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" width=\"5\" height=\"1\" alt=\"\" /></td>\r\n    <td id=\"tabs1\" class=\"tabs\" onclick=\"toggleTab(1)\">Search/Filter</td>\r\n    <td width=\"100%\" class=\"tabspacer\">&nbsp;</td>\r\n  </tr>\r\n  <tr id=\"tab1\" style=\"display:none;\">\r\n    <td colspan=\"3\" class=\"tab\"><form action=\"box.php\" method=\"get\">\r\n        <p align=\"center\">Search in\r\n          ";
echo "<s";
echo "elect name=\"search\" class=\"select\">\r\n            <option value=\"boxid\"";
if ( $search == "boxid" )
{
    echo " selected=\"selected\"";
}
echo ">Box ID</option>\r\n            <option value=\"name\"";
if ( $search == "name" )
{
    echo " selected=\"selected\"";
}
echo ">Name</option>\r\n            <option value=\"location\"";
if ( $search == "location" )
{
    echo " selected=\"selected\"";
}
echo ">Location</option>\r\n            <option value=\"ip\"";
if ( $search == "ip" )
{
    echo " selected=\"selected\"";
}
echo ">IP Address</option>\r\n          </select>\r\n          for\r\n          <input type=\"text\" name=\"q\" class=\"text\" size=\"40\" value=\"";
if ( !empty( $q ) )
{
    echo $q;
}
echo "\" />\r\n          <input type=\"submit\" value=\"Search\" class=\"button\" />\r\n        </p>\r\n      </form></td>\r\n  </tr>\r\n</table>\r\n";
echo "<s";
echo "cript language=\"javascript\" type=\"text/javascript\">var numtabs = 1;</script>\r\n<table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">\r\n  <tr>\r\n    <td><b>";
echo $numrecords;
echo " Records Found, Page ";
echo $pagenum;
echo " of ";
echo $numpages;
echo "</b> (<a href=\"boxadd.php\">Add New Box</a>)</td>\r\n    ";
if ( 1 <= $numpages )
{
    echo "    <td align=\"right\"><form method=\"get\" action=\"box.php\">\r\n        ";
    if ( !empty( $orderby ) && $orderby != "clientid" )
    {
        echo "<input type=\"hidden\" name=\"orderby\" value=\"";
        echo $orderby;
        echo "\" />";
    }
    echo "        ";
    if ( !empty( $dir ) )
    {
        echo "<input type=\"hidden\" name=\"dir\" value=\"";
        echo $dir;
        echo "\" />";
    }
    echo "        ";
    if ( !empty( $search ) )
    {
        echo "<input type=\"hidden\" name=\"search\" value=\"";
        echo $search;
        echo "\" />";
    }
    echo "        ";
    if ( !empty( $q ) )
    {
        echo "<input type=\"hidden\" name=\"q\" value=\"";
        echo $q;
        echo "\" />";
    }
    echo "        ";
    if ( !empty( $_GET['rows'] ) )
    {
        echo "<input type=\"hidden\" name=\"rows\" value=\"";
        echo ( $_GET['rows'] );
        echo "\" />";
    }
    echo "        Jump to Page:\r\n        ";
    echo "<s";
    echo "elect name=\"page\" class=\"select\" onchange=\"submit();\">\r\n          ";
    $n = 1;
    while ( $n <= $numpages )
    {
        echo "          <option value=\"";
        echo $n;
        echo "\"";
        if ( $pagenum == $n )
        {
            echo " selected=\"selected\"";
        }
        echo ">";
        echo $n;
        echo "</option>\r\n          ";
        ++$n;
    }
    echo "        </select>\r\n      </form></td>\r\n      ";
}
echo "  </tr>\r\n</table>\r\n<form name=\"boxes\" action=\"\">\r\n  <table width=\"100%\" cellpadding=\"1\" cellspacing=\"1\" class=\"data\">\r\n    <tr>\r\n      <th width=\"20\">#</th>\r\n      <th><a href=\"box.php?orderby=boxid";
if ( $orderby == "boxid" && empty( $dir ) )
{
    echo "&amp;dir=desc";
}
echo $linkend;
echo "\">ID</a>\r\n        ";
if ( $orderby == "boxid" )
{
    echo $dirImage;
}
echo " / <a href=\"box.php?orderby=name";
if ( $orderby == "name" && empty( $dir ) )
{
    echo "&amp;dir=desc";
}
echo $linkend;
echo "\">Name</a>\r\n        ";
if ( $orderby == "name" )
{
    echo $dirImage;
}
echo "</th>\r\n      <th><a href=\"box.php?orderby=location";
if ( $orderby == "location" && empty( $dir ) )
{
    echo "&amp;dir=desc";
}
echo $linkend;
echo "\">Location</a>\r\n        ";
if ( $orderby == "location" )
{
    echo $dirImage;
}
echo "</th>\r\n      <th><a href=\"box.php?orderby=ip";
if ( $orderby == "ip" && empty( $dir ) )
{
    echo "&amp;dir=desc";
}
echo $linkend;
echo "\">IP Address</a>\r\n        ";
if ( $orderby == "ip" )
{
    echo $dirImage;
}
echo "</th>\r\n      <th width=\"55\">IPs</th>\r\n      <th width=\"55\">Servers</th>\r\n      <th>SSH</th>\r\n      <th>FTP</th>\r\n      <th>CPU</th>\r\n    </tr>\r\n    ";
if ( ( $result ) == 0 && empty( $q ) && empty( $status ) )
{
    echo "    <tr>\r\n      <td colspan=\"11\"><div id=\"infobox2\">";
    echo "<s";
    echo "trong>No Boxes Found</strong><br />\r\n          No boxes found. <a href=\"boxadd.php\">Click here</a> to add a new box.</div></td>\r\n    </tr>\r\n    ";
}
else if ( ( $result ) == 0 && ( !empty( $q ) || !empty( $status ) ) )
{
    echo "    <tr>\r\n      <td colspan=\"11\"><div id=\"infobox2\">";
    echo "<s";
    echo "trong>No Boxes Found</strong><br />\r\n          Modify your search.</div></td>\r\n    </tr>\r\n    ";
}
echo "    ";
$n = 1;
while ( $rows = ( $result ) )
{
    echo "    <tr onmouseover=\"this.className='mouseover'\" onmouseout=\"this.className=''\">\r\n      <td style=\"color:#666666;\">";
    echo $n;
    echo "</td>\r\n      <td><a href=\"boxsummary.php?id=";
    echo $rows['boxid'];
    echo "\">#";
    echo $rows['boxid'];
    echo " - ";
    echo $rows['name'];
    echo "</a></td>\r\n      <td>";
    echo $rows['location'];
    echo "</td>\r\n      <td>";
    echo $rows['ip'];
    echo "</td>\r\n      <td>";
    echo ( "SELECT `ipid` FROM `ip` WHERE `boxid` = '".$rows['boxid']."'" );
    echo "</td>\r\n      <td>";
    echo ( "SELECT `serverid` FROM `server` WHERE `boxid` = '".$rows['boxid']."'" );
    echo "</td>\r\n      <td>";
    echo ( $rows['ssh'] );
    echo "</td>\r\n      <td>";
    echo ( $rows['ftp'] );
    echo "</td>\r\n      <td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"2\">\r\n        <tr>\r\n          <td align=\"center\"><b><u>Load</u></b></td>\r\n          <td align=\"center\"><b><u>Idle</u></b></td>\r\n        </tr>\r\n        <tr>\r\n          <td align=\"center\">";
    echo $rows['load'];
    echo "</td>\r\n          <td align=\"center\">";
    echo $rows['idle'];
    echo "</td>\r\n        </tr>\r\n      </table></td>\r\n    </tr>\r\n    ";
    ++$n;
}
( $result );
echo "  </table>\r\n  <img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" height=\"5\" width=\"1\" alt=\"\" /><br />\r\n  <div align=\"right\" style=\"color:#666666;font-size:11px;\">Last Update: ";
echo ( $rows1['value'] );
if ( ( $rows1['value'] ) == "Never" )
{
    echo "<br />Setup the cron job to enable box monitoring!";
}
echo "</div>\r\n</form>\r\n<table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">\r\n  <tr>\r\n    <td align=\"right\"><form method=\"get\" action=\"box.php\">\r\n        ";
if ( !empty( $orderby ) && $orderby != "boxid" )
{
    echo "<input type=\"hidden\" name=\"orderby\" value=\"";
    echo $orderby;
    echo "\" />";
}
echo "        ";
if ( !empty( $dir ) )
{
    echo "<input type=\"hidden\" name=\"dir\" value=\"";
    echo $dir;
    echo "\" />";
}
echo "        ";
if ( !empty( $search ) )
{
    echo "<input type=\"hidden\" name=\"search\" value=\"";
    echo $search;
    echo "\" />";
}
echo "        ";
if ( !empty( $q ) )
{
    echo "<input type=\"hidden\" name=\"q\" value=\"";
    echo $q;
    echo "\" />";
}
echo "        Rows Per Page:\r\n        ";
echo "<s";
echo "elect name=\"rows\" class=\"select\" onchange=\"setCookie('boxrows',this.value,30);submit();\">\r\n          <option value=\"15\" ";
if ( $rowsperpage == 15 )
{
    echo " selected=\"selected\"";
}
echo ">15</option>\r\n          <option value=\"25\" ";
if ( $rowsperpage == 25 )
{
    echo " selected=\"selected\"";
}
echo ">25</option>\r\n          <option value=\"50\" ";
if ( $rowsperpage == 50 )
{
    echo " selected=\"selected\"";
}
echo ">50</option>\r\n          <option value=\"100\" ";
if ( $rowsperpage == 100 )
{
    echo " selected=\"selected\"";
}
echo ">100</option>\r\n          <option value=\"All\" ";
if ( $rowsperpage == 999999 )
{
    echo " selected=\"selected\"";
}
echo ">All</option>\r\n        </select>\r\n      </form></td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>
