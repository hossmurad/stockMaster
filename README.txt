Upgraded StockMaster - Bootstrap UI + dompdf integration (fallback to browser Print)
-------------------------------------------------------------------------------

This upgraded package uses Bootstrap for UI. Invoice generation attempts to use dompdf (server-side PDF generation).
If dompdf is not installed on your server, the system will open a printable HTML invoice you can Save as PDF via browser Print.

To enable automatic PDF downloads you MUST install dompdf on your server. Steps (recommended):
1. SSH into your hosting account (or use control panel terminal) and run inside the stockmaster folder:
   composer require dompdf/dompdf
2. After composer installs, ensure vendor/autoload.php exists on server.

If you cannot run composer on server, you can ask your host to install dompdf or follow host's composer support docs.

for login the system firstly you nedd to go config.php file set username and password there and save the file and then log in the system


Upload instructions:
1. Upload and extract this folder into your web root (e.g., public_html/stockmaster).
2. Edit config.php if needed (DB credentials).
3. Visit install.php and click Create Tables once.
4. Delete install.php after install.
5. (Optional) Install dompdf via composer for automatic PDF download.
