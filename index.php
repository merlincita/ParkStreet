<?php 
    require './dao/ClientController.php';
    $clients = ClientController::getClients();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Programming Test</title>               
        <link href="layout.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="lib/jquery-1.11.1.js"></script>
        
        <script  type="text/javascript">            
            $(document).ready(function(){
               $('#showdata').click(function(){ // return all data
                   $("#products").empty();
                   $("#client").val('0');
                   $.ajax({
                        type : 'POST',
                        dataType: "json", 
                        url  : './actions/jsonprocess.php',
                        success: function(dataSource){ // dataSource = json object
                            if (dataSource.length > 0) {
                                var r = '';
                                for (var key = 0; key < dataSource.length; key++){
                                    r = '<tr>';
                                    r += '<td>' + dataSource[key].invoice_num + '</td>';
                                    r += '<td>' + dataSource[key].invoice_date + '</td>';
                                    r += '<td>' + dataSource[key].description + '</td>';
                                    r += '<td>' + dataSource[key].qty + '</td>';
                                    r += '<td>' + dataSource[key].price + '</td>';
                                    r += '<td>' + dataSource[key].total + '</td>';
                                    r += '</tr>';
                                    $('#displayData > tbody:last').append(r);
                                }
                                $('#displayData').css('display', 'block');                                
                            }
                            else {
                                $('#displayData').css('display', 'none');
                            }
                            $('#result').text(dataSource.length + " records found.");
                        }
                   });
                   return false;
               });
               
               $('#showfilterdata').click(function(){
                   var typeSearch = $('#dateparam').val();
                   $.ajax({
                        type : 'POST',
                        data: {type: typeSearch}, 
                        url  : './actions/dbprocess.php',
                        success: function(dataSource){
                            if (dataSource !== '') {
                                $('#displayData tbody').html(dataSource);
                                $('#displayData').css('display', 'block');
                            }
                            else {                                
                                $('#displayData').css('display', 'none');
                            }
                            $('#result').text($('#displayData tbody tr').length + " records found.");
                        }
                   });
                   return false;
               });
               
               $("#dateparam").change(function() { // event that occurs when the Date dropdown changes its value
                   $('#result').text('');
                   $('#displayData tbody').empty();
                   $('#displayData').css('display', 'none');
                   $("#products").empty();
                   $("#client").val('0');
               });
                   
               $("#client").change(function() {
                    $('#displayData tbody').empty();
                    if ($(this).val() != 0) {                        
                        $.ajax({
                            type : 'POST',
                            data: {client: $(this).val()}, 
                            url  : './actions/transactions.php',
                            success: function(clientSource){
                                if (clientSource !== '') {
                                    $('#displayData tbody').html(clientSource);
                                    $('#displayData').css('display', 'block');
                                    $("#products").empty();                                    
                                    $("td[id='description']", clientSource).each(function() {
                                        // this if is to avoid showing repeated products.
                                        if ($("#products option[value='" + $(this).text() + "']").length == 0) {
                                           $("#products").append("<option value='" + $(this).text() +"'>"+ $(this).text() +"</option>");
                                        }
                                    });
                                }
                                else {                                
                                    $('#displayData').css('display', 'none');
                                }
                                $('#result').text($('#displayData tbody tr').length + " records found.");
                            }
                       });
                    }
                    else { // remove items de products                        
                        $('#result').text('');
                        $("#products").empty();
                        $('#displayData').css('display', 'none');
                    }                    
                    return false;
               });
               
            });
        </script>
    </head>
    <body>
        <form>   
            <div style="float: left; width: 25%">
                <input type="submit" id="showdata" name="showdata" value="Show all records">
            </div>
            <div style="float: left; width: 35%">
                <select name="dateparam" id="dateparam">
                    <option value="1">Last Month to Date</option>
                    <option value="2">This Month</option>
                    <option value="3">This Year</option>
                    <option value="4">Last Year</option>
                </select>
                <input type="submit" id="showfilterdata" name="showfilterdata" value="Show Filtered Data">
            </div>            
            <div style="float: right; width: 40%">
                <select id="client" name="client">
                    <option value="0" selected="">Select a client</option>
                    <?php
                    foreach($clients as $client) {
                        echo '<option value="'. $client[0] . '">'. $client[1] . '</option>';
                    }
                    ?>
                </select>
                <select id="products" name="products">
                </select>
            </div>
            <div style="clear: both"></div>
        </form>
        <br>
        <span id="result"></span><br>
        <table id="displayData" style="display: none;" class="centeredtable">
            <thead>
                <tr>
                    <th>Invoice Num</th>
                    <th>Invoice Date</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        
    </body>
</html>