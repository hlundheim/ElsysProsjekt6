<style>
    body{
        height: 100%;
    }

    main{
        width: 95%;
        margin-top: 0;
    }

    #grid-gif{
        width: 100%;
        margin-top: 20%;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-gap: 20px;
    }

    .hoverable {
        /*display: inline-block;
        width: 300px;
        height: 170px;*/
        width: 450px;
        height: 250px;
        border: none !important;
    }

    #show1{
        background: center url('Bilder/ulrikke.jpg') no-repeat;
        background-size: contain;
    }

    #show1:hover{
        background-image: url('https://media.giphy.com/media/UE0YK53vvT7LSQthFM/giphy.gif');
    }


    #show2{
        background: center url('Bilder/skrillex.jpg') no-repeat;
        background-size: contain;
    }

    #show2:hover{
        background-image: url('https://media.giphy.com/media/PEnke4GED85Owctf3T/giphy.gif');
    }

    #show3{
        background: center url('Bilder/ekko.jpg') no-repeat;
        background-size: contain;
    }

    #show3:hover{
        background-image: url('https://media.giphy.com/media/SJbqcpAbEq4cobzGrI/giphy.gif');
    }

</style>