
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hire letter</title>
    {{-- <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Noto+Serif+Ethiopic:wght@700&display=swap"
        rel="stylesheet"> --}}
    <style>
        @font-face {
            font-family: 'Ethiopian';
            src: url({{ storage_path('fonts/jiret.ttf') }}) format('truetype'), url({{ storage_path('fonts/jiret.woff') }}) format('woff');
        }

body{


}
    </style>
</head>

<body>
    <div class ="container">

            <h6 style=" text-align:  right; font-size: 12px; font-family: 'Noto Serif Ethiopic'"> ቁጥር _____________________ </h6> 
            <h6 style="text-align:  right; font-size: 12px; font-family: 'Noto Serif Ethiopic'">ቀን _______________________ </h6> 
        
             @if(is_null($employee->first_name_am ))

             <h6 style="text-align:  left; font-size: 12px; font-family: 'Noto Serif Ethiopic'"> ለአቶ/ወ/ሮ/ሪት : {{ $employee->first_name }} {{ $employee->father_name }} {{ $employee->grand_father_name}}  </h6>
       
              @else
              <h6 style="text-align:  left; font-size: 12px; font-family: 'Noto Serif Ethiopic'"> ለአቶ/ወ/ሮ/ሪት : {{ $employee->first_name_am  }} {{ $employee->father_name_am  }} {{ $employee->grand_father_name_am }}  </h6>
          
             @endif
          
              <h6 style="text-align:  left; font-size: 12px; font-family: 'Noto Serif Ethiopic'"> <u>ጅማ ዩኒቨርሲቲ </u>  </h6> 
        
        <span class="text-justify font-weight-normal">
            <h6 style="text-align: center; font-size: 12px;  font-family: 'Noto Serif Ethiopic'"> <strong> ጉዳዩ፡-  </strong><u>ለ6 ወር የሙከራ ጊዜ መቀጠርዎን ስለማሳወቅ፡  </u>  </h6> 
  
            <h6 style="font-size: 12px; font-family: 'Noto Serif Ethiopic'">  {!! nl2br(e( strip_tags($body))) !!}  </h6>
        
                <h6 style="text-align:  right; font-size: 12px; font-family: 'Noto Serif Ethiopic'"> ከሰላምታ ጋር</h6> 
    
        </span>

        <h6 style="font-size: 12px; font-family: 'Noto Serif Ethiopic'"> 
        <ul>
           
           <strong> ግልባጭ// </strong> 
            <li>ለፕሬዝዳንት ጽ/ቤት </li> 
            <li>ለአስተዳደርና የተማሪዎች አገ/ም/ፕሬዚዳንት </li> 
            <li> ለሰው ሀብት አስተዳደርና ልማት ዳይሬክቶሬት </li> 
            <li>ለክፍያና ሂሳብ አስተዳደር ዳይሬክቶሬት </li> 
            <li>ለኦዲት አገልግሎት ዳይሬክተር </li> 
            <li> ለስትራተጂክ ማኔጅመንት ሲኒየር ዳይሬክተር ጽ/ቤት </li> 
            <li> ለአይሲቲ ልማት ዳይሬክቶሬት </li> 
            <li> ለሰው ሀብት ዳታ ኢንኮደር </li> 
            <li> ጅማ ዩኒቨርሲቲ </li> 
       
        </ul>
    </h6> 

    <h6 style="font-size: 12px; font-family: 'Noto Serif Ethiopic'"> 
          <ul>
        
         <li>የመንግስት ሠራተኞች ማህበራዊ ዋስትና ኤጀንሲ </li>   
         ለደቡብ ምዕራብ ሪጅን ጽ/ቤት<br>
         ከ1 ገጽ የህይወት ታሪክ ፎርም ጋር<br>
         h1 ገጽ ቅጽ ጡረታ ጋር<br>
         ጅማ
        </u>
         </strong>
        </h6>

        {{-- ETB  {{  number_format($sum,2)  }} --}}
    </div>
   
</body>

</html>
