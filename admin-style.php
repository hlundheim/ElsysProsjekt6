<style>
    body{
        height: 100%;
    }

    main{
        width: 80%;
        margin-top: 0;
    }

    h2{
        padding: 40px;
        text-align: center;
        margin-top: 5%;
    }

    h3{
        text-align: center;
    }

   /*.wrapper{
        width: 100%;
        padding-top: 50px;
    }
    .col_3{
        margin-top: 20%;
        width: 33.3333333%;
        float: left;
        min-height: 1px;
        float: center;
        text-align: center;
    }*/

    #submit_button{
        background-color: #643d9c; 
        color: #FFF; 
        font-weight: bold; 
        font-size: 30; 
        border-radius: 15px;
        text-align: center;
        cursor: pointer;
    }

    

    #valg{
        width: 100%;
        margin-top: 2%;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-gap: 30px;
        /*margin-top: 100px;*/
    }
    .led_img{
        height: 400px;		
        width: 100%;
        object-fit: cover;
        object-position: center;
    }

    @media only screen and (max-width: 600px) {
        .col_3 {
            width: 100%;
        }
        .wrapper{
            width: 100%;
            padding-top: 5px;
        }
        .led_img{
            height: 300px;		
            width: 80%;
            margin-right: 10%;
            margin-left: 10%;
            object-fit: cover;
            object-position: center;
        }
    }

</style>