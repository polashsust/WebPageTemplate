/**
 * frontend functions
 * \author sue
 */
Frontend.prototype = {
  game_: null,
  container_: null,
  numbercontainer_: null,
  numbercontainertext_: "",
  
  /**
  * Draw grey boxes
  */
  drawGreyBoxes: function(loss) {
    loss = typeof loss !== "number" ? 0 : loss;
    
    $mandatorycount = this.game_.minnumbers_ - loss;
    
    for ($i=0; $i<(this.game_.maxnumbers_ - loss); $i++) {
        $cssClass = "ui-btn-" + ($i<$mandatorycount ? "mandatory" : "optional");
        var $txt = $("<span></span>").addClass("ui-btn-text");
        var $envelope = $("<span></span>").addClass("ui-btn-inner").append($txt);
        $("<a></a>").addClass("ui-btn ui-btn-inline " + $cssClass).append($envelope).appendTo(this.container_);
        this.container_.append(" \n");
    }
  },
  
  /**
  * Change min required number count
  */
  changeRequiredNumberCount: function(numbercount) {
    numbercount = this.game_.minnumbers_ - (typeof numbercount !== 'number' ? 0 : numbercount);
    
    $spans = this.numbercontainer_.children("span");
    $first = this.numbercontainer_.children("span:first-child");
    $last = this.numbercontainer_.children("span:last-child");
    
    if (numbercount <= 0) {
        $spans.hide();
        $last.show();
        return;
    }
    
    if (this.game_.minnumbers_ != this.game_.maxnumbers_) {
        numbercount = "min. " + numbercount;
    }
    $spans.hide();
    $first.show();
    $first.children("span").html(numbercount);
  },
  
  /**
  * Show please wait message
  */
  showPleaseWait: function(show) {
      show = typeof show == "boolean" ? show : false;
      
      $spans = this.numbercontainer_.children("span");
      $pleasewait = this.numbercontainer_.children("span:nth-child(2)");
      $last = this.numbercontainer_.children("span:last-child");
      
      if (show) {
          $spans.hide();
          $pleasewait.show();
      } else {
          $spans.hide();
          $last.show();
      }
  }
};

/**
* ctor for frontend
*/
function Frontend(game, container, numbercontainer) {
    this.game_ = game;
    this.container_ = container;
    this.numbercontainer_ = numbercontainer;
    this.numbercontainertext_ = this.numbercontainer_.text();
}
