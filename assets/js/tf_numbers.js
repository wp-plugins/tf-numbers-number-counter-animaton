/*
* TF-Numbers
* Author : Aleksej Vukomanovic
*/

//Statistics in numbers
jQuery.fn.statsCounter = function(){
   //declaring vars
    var stat = this.find('.statistics-inner').children();
    var startValue = 0;
    
    //iterate through every .stat class and collect values
   stat.each(function(){
      var count = jQuery(this).data('count');
      var number = jQuery(this).find('.number');
      var start = 0;
      var go = setInterval(function(){ startCounter(); },1); //increment value every 1ms

      function startCounter(){
          incrementBy = Math.round(count / 90); //Divide inputed number by 90 to gain optimal speed (not too fast, not too slow)
          if( count < 90 ) incrementBy = Math.round(count / 5);
          start = start + incrementBy;
          jQuery(number).text(start);
          //if desired number reched, stop counting
          if( start === count ) {
              clearInterval(go);
          } else if( start >= count ){ //or if greater than selected num - stop and return value
              clearInterval(go);
              jQuery(number).text(count);
          }
      }//startCounter;
  });//stat.each()
}//statsCounter();

  //if visible src = http://www.rupertlanuza.com/how-to-check-if-element-is-visible-in-the-screen-using-jquery/
  function isElementVisible(elementToBeChecked) {
    var TopView = jQuery(window).scrollTop();
    var BotView = TopView + jQuery(window).height();
    var TopElement = jQuery(elementToBeChecked).offset().top;
    var BotElement = TopElement + jQuery(elementToBeChecked).height();
    return ((BotElement <= BotView) && (TopElement >= TopView));
  }

jQuery(document).ready(function(jQuery){

   var statistics = jQuery('.statistics');

   if( statistics.length > 0 ) {

     var title = statistics.find('h2');
     var countTitles = statistics.find('.count-title');
     var numbers = statistics.find('.number');
     var icons = statistics.find('.fa');
     var bg;
   
	   title.css( 'color', statistics.data('title-color') );
	   icons.css( 'color', statistics.data('icons-color') );
	   numbers.css( 'color', statistics.data('numbers-color') );
	   countTitles.css( 'color', statistics.data('count-titles') );
	   if( statistics.data('background').indexOf('.png') > -1 || statistics.data('background').indexOf('.jpg') > -1 || statistics.data('background').indexOf('.jpeg') > -1 ){
	    bg = 'url('+statistics.data('background')+') no-repeat'; 
	   } else {
	    bg = statistics.data('background');
	   }
	   statistics.css('background', bg);

	    //setting counts to 0
	   if( jQuery('.stat').length > 0 ){
	      var stat = jQuery('.stat');
	      stat.each(function(){
	        stat.find('.number').text(0);
	      })
	    }
	    //animating when scrolled
	    var countDone = 0;
	    jQuery(window).scroll(function(){
	      //if .statistics exists, initialize
	    if( jQuery('.statistics').length ){
	      var visible = isElementVisible('.statistics');
	    
	    //if stats section visible, start the counting after 400ms
	     if( visible && countDone == 0 ) { //check if it's not already done
	       setTimeout(function(){
	        jQuery('.statistics').statsCounter();
	        countDone = 1;
	       },400);
	      }//if visible && not shown
	    }//if exists
	    });//scroll function
      
	}
})
