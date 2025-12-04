<!doctype html>
<html class="dark">

<head>
    <title>@if(isset($site_setting['website_title'])){{$site_setting['website_title']}}@else{{"Website Name"}}@endif</title>
</head>

<body class="block min-h-screen bg-[#000000]">
    
    <div id="mobile" class="demo2 relative min-h-screen">
        <div id="mobileBodyContent">
             <section class="relative py-24 overflow-hidden md:w-1/2 mx-auto">
                <div class="container px-4 mx-auto relative">
              
                    <h3 class="text-4xl lg:text-5xl text-center font-heading mb-12 text-yellow-600"><b>Technical Upgradation</b></h3>
                  <div class="mx-auto text-center text-white relative z-10">
                    <p class="mb-10">Dear Clients,
            This is to Inform you that Techinical upgradation is in progress on our Server due to which you will not be able to login CRM
            This activity will be completed by today EOD or by tomorrow,
            We will keep you posted on the same,
            Thanks & Regards,
            Truepoints</p>
                    <!-- Timer display -->
                    <div id="countdown" class="text-2xl font-bold text-white mb-4"></div>
                    <!-- <a class="inline-block px-8 py-3 text-white font-bold bg-black hover:bg-gray-900" href="{{route('fdashboard')}}">Go back to Homapage</a> -->
                  </div>
                </div>
              </section>
        </div>
    </div>

</body>

</html>
