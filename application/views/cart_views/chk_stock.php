<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .chkout_stock_form{
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 5rem;
        }
        .ship button{
            margin-right: 5rem;
            height: 3rem;
            width: 15rem;
            background-color:  #eb4055;
            color: white;
            border-radius: 0.3rem;
        }
        .stock .stock_link{
            display: flex;
            align-items: center;
            justify-content: center;
            height: 3rem;
            width: 15rem;
            background-color:  #eb4055;
            color: white;
            border-radius: 0.3rem;
            
        }
        .stock a{
            text-decoration: none;
        }
        #page_one, #page_two, #page_three{
           display: none;   
        }
       
    </style>
</head>
<body>
    <form action="<?php echo base_url('index.php/Habit/check_out');?>" method="POST" class="chkout_stock_form">
        <div class="ship">
            <button type="submit" name="pay_ship"><h4>PAY AND SHIP</h4></button>
        </div>
         
        <div class="stock">
            <a href="<?php echo base_url('index.php/Habit/stock_piller/'); ?>" id="read">
                <div class="stock_link"><h4>PAY AND STOCKPILE 😎</h4></div>
            </a>
            <!-- <a href="" >Read More about our beautiful concept of stockpiling </a> -->
            <h4 id="page_one">
                Our stockpiling concept is simple
                we give you complete control over
                where and when u want ur products
                for a flexible monthly storage fee
            </h4>
            <h4 id="page_two">
                we give you price updates and options
                to help you fully do whatever u want 
                with ur product(s)
                its not just shopping
                its whatever you want it to be.
            </h4>
            <h4 id="page_two">
                do ur birthday shopping,holiday shopping 
                as early as you want,put more thougts into it
                and just let us know whenever you are ready to 
                put a smile on ur loved one face.
            </h4>
        </div>
        
    </form>
    <script>
        // let read = document.querySelector('#read');
        // read.addEventListener('mouseover',function(e){
        //     e.preventDefault();
        //     pages();
        // });
        // read.addEventListener('mousein',function(e){
        //     e.preventDefault();
        //     pages();
        // });
        // read.addEventListener('mouseout',pageOut);

        // let page_one = document.querySelector('#page_one');
        // let page_two = document.querySelector('#page_two');
        // let page_three = document.querySelector('#page_three');

        // let page_list = [page_one, page_two, page_three];

        // function pages (){
        //     // console.log('hey');
        //     random_page = page_list[Math.floor(Math.random() * page_list.length)];

        //     // page_list[0].style.display = 'block'
        //     if(random_page.style.display == 'none'){
        //         random_page.style.display = 'block';
        //     }
        //     else{
        //         random_page.style.display = 'none'

        //     }
        // }
        // let y = document.querySelector('#page_two');

        // function pageOut(){
        //     for (let i = 0; i < page_list.length; i++){
        //         page_list[i].style.display = 'none';
        //     }
        // }


    </script>
</body>
</html>