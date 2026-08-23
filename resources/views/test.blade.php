<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <style>
        body *{
            color: #000 !important;
            margin: 0 !important;
            padding: 0 !important;
            background-color: #fff !important;
            height: auto !important;
            font-size: 13px !important;
        }
        img{
            display: none !important;
        }
    </style>
</head>
<body>
    @foreach($cms_page as $key => $item)
        <?php
            $club = DB::table('customer_group')->where("customer_group_id", $item->group_id)->first();
            $club = (isset($club) ? $club->customer_group_code : "");
        ?>
        <div class="row">
            <div class="col-sm-1">{!! $key+1 !!}</div>
            <div class="col-sm-2">{!! $item->email !!}</div>
            <div class="col-sm-1">{!! DB::table('customer_entity_varchar')->where("entity_id", $item->entity_id)->where("attribute_id", 5)->first()->value !!}</div>
            <div class="col-sm-1">{!! DB::table('customer_entity_varchar')->where("entity_id", $item->entity_id)->where("attribute_id", 7)->first()->value !!}</div>
            <div class="col-sm-3">{!! DB::table('customer_entity_varchar')->where("entity_id", $item->entity_id)->where("attribute_id", 12)->first()->value !!}</div>
            <div class="col-sm-2">{!! DB::table('customer_entity_varchar')->where("entity_id", $item->entity_id)->where("attribute_id", 3)->first()->value !!}</div>
            <div class="col-sm-1">{!! $club !!}</div>
        </div>
    @endforeach
</body>
</html>