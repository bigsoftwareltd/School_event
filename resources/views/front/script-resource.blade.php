@section('script-resource')
    <script src="{{asset('/admin/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/admin/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('/admin/jquery-knob/jquery.knob.min.js')}}"></script>
    <script src="{{asset('/admin/bootstrap/js/bootstrap.min.js')}}"></script>
{{--    <script src="vendor/jquery/jquery.slim.min.js"></script>--}}

{{--    <script src="/path/to/jquery.min.js"></script>--}}
    <script src="jquery.marquee.js"></script>
    <script type="text/javascript">
        $('.carousel').carousel()
        $('.marquee').marquee({

            // Set to false if you want to use jQuery animate method
            allowCss3Support: true,

            // CSS3 easing function
            css3easing: 'linear',

            // Requires jQuery easing plugin.
            easing: 'linear',

            // Time to wait before starting the animation
            delayBeforeStart: 1000,

            // 'left', 'right', 'up' or 'down'
            direction: 'left',

            // Should the marquee be duplicated to show an effect of continues flow
            duplicated: true,

            // Duration of the animation
            duration: 5000,

            // Space in pixels between the tickers
            gap: 20,

            // On cycle pause the marquee
            pauseOnCycle: false,

            // Pause on hover
            pauseOnHover: false,

            // The marquee is visible initially positioned next to the border towards it will be moving
            startVisible: false

        });
    </script>
    <script>
        $(function () {
            // $(".navbar-nav .nav-item").mouseover(function () {
            //     console.log("hoiche");
            //     $(this).children(".dropdown-menu").addClass("show");
            //     $(this).children(".dropdown-toggle").addClass("active");
            //     $(this).mouseleave(function () {
            //         $(this).children(".dropdown-menu").removeClass("show");
            //         $(this).children(".dropdown-toggle").removeClass("active");
            //     })
            // })
            var i = 0;
            $("#header-navigation .menu-toggle").click(function (){
                i++;
                if(i%2 == 1){
                    $(this).addClass("selected");
                    $(this).parent().addClass("toggled-on");
                    $(this).parent("#header-navigation").children(".header-menu-content").css("display","block");
                }
                else{
                    $(this).removeClass("selected");
                    $(this).parent().removeClass("toggled-on");
                    $(this).parent("#header-navigation").children(".header-menu-content").css("display","none");
                }
            })
        })
        // Auto Typewriter is start here
        var _CONTENT = [
            "100 Year Celebration Ali azam School",
        ];

        // Current sentence being processed
        var _PART = 0;

        // Character number of the current sentence being processed
        var _PART_INDEX = 0;

        // Holds the handle returned from setInterval
        var _INTERVAL_VAL;

        // Element that holds the text
        var _ELEMENT = document.querySelector("#text");

        // Cursor element
        var _CURSOR = document.querySelector("#cursor");

        // Implements typing effect
        function Type() {
            // Get substring with 1 characater added
            var text =  _CONTENT[_PART].substring(0, _PART_INDEX + 1);
            _ELEMENT.innerHTML = text;
            _PART_INDEX++;

            // If full sentence has been displayed then start to delete the sentence after some time
            if(text === _CONTENT[_PART]) {
                // Hide the cursor
                _CURSOR.style.display = 'none';

                clearInterval(_INTERVAL_VAL);
                setTimeout(function() {
                    _INTERVAL_VAL = setInterval(Delete, 50);
                }, 1000);
            }
        }

        // Implements deleting effect
        function Delete() {
            // Get substring with 1 characater deleted
            var text =  _CONTENT[_PART].substring(0, _PART_INDEX - 1);
            _ELEMENT.innerHTML = text;
            _PART_INDEX--;

            // If sentence has been deleted then start to display the next sentence
            if(text === '') {
                clearInterval(_INTERVAL_VAL);

                // If current sentence was last then display the first one, else move to the next
                if(_PART == (_CONTENT.length - 1))
                    _PART = 0;
                else
                    _PART++;

                _PART_INDEX = 0;

                // Start to display the next sentence after some time
                setTimeout(function() {
                    _CURSOR.style.display = 'inline-block';
                    _INTERVAL_VAL = setInterval(Type, 100);
                }, 200);
            }
        }

        // Start the typing effect on load
        _INTERVAL_VAL = setInterval(Type, 100);
        // Auto typewriter is end here
    </script>
@endsection
