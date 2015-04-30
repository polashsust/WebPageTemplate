/**
* freelotto.js
* \author ck
*/
Freelotto.prototype = {
	// Configuration
  maxnumbers_: 7,  // Maximum amount of numbers to accept
	minnumbers_: 7,  // Minimum amount of n. to require before showing payment icon
  
  // Properties
	numbers_: [],  // Array of choices in order of choice by the user,
  activeclass_: "active",
  buttonclass_: null,  // Class of the buttons
  randomizerid_: null,  // ID of the randomizer
  resetid_: null,  // ID of the reset button
	numbercontainerid_: "numbercontainer",  // ID of the number container 
  
  // Events
  onpayable: function(){},
  onnotpayable: function(){},
  
  /**
  * Triggered when a choice is made or unset
  */
  onchoice: function() {},
  
	/**
	* User made a choice, push it into the array.  Continue to re-evaluate
  * payment possibility.
	* \param int number
	*/
	setChoice: function(number) {
		this.numbers_.push(number);
    this.checkCanPay();
    this.onchoice();
  },
  
  /**
  * Unset a specific number from the array.
  * \param int number
  */
  unsetChoice: function(number) {
    this.numbers_.splice(this.numbers_.indexOf(number), 1);
    this.checkCanPay();
    this.onchoice();
  },
	
	/**
	* Check whether we can still accept new choices
	* \return boolean True if we can still accept numbers.
	*/
	canSetChoice: function() {
		return this.numbers_.length < this.maxnumbers_;
	},
	
	/**
	* Check whether we still need more numbers before we can do anything.
	* \return boolean True if we need to accept more numbers.
	*/
	mustSetChoice: function() {
		return this.numbers_.length < this.minnumbers_;
	},
  
  /**
  * Reset everything
  */
  resetChoices: function() {
    $("." + this.activeclass_).removeClass(this.activeclass_);
    this.numbers_ = [];
    this.onchoice();
    this.checkCanPay();
  },
  
  /**
  * Randomize left numbers.
  */
  randomizeLeftNumbers: function() {
    // Build an array of buttons
    var allbuttons = this.getButtons().not("." + this.activeclass_).toArray();
    while (this.mustSetChoice()) {
      var thebutton = allbuttons.splice(Math.floor(Math.random() * allbuttons.length), 1);
      $(thebutton).trigger("click");
    }
  },
  
  /**
  * Check whether we can start a transaction.
  */
  checkCanPay: function() {
    if (this.mustSetChoice()) {
      return this.handleCannotPay();
    }
    
    return this.handleCanPay();
  },
  
  /**
  * Subroutine to deal with what happens when we cannot pay.
  */
  handleCannotPay: function handleCannotPay() {
    this.onnotpayable(this.numbers_);
  },
  
  /**
  * Subroutine to deal with what happens when we can pay.
  */
  handleCanPay: function handleCanPay() {
    this.onpayable(this.numbers_);
  },
  
  /**
  * Get buttons as jQuery
  * \return jQuery
  */
  getButtons: function() {
    return $("." + this.buttonclass_);
  },
  
  /**
  * Initialize events on a given button class.  These elements correspond
  * to the elements known in |elements_|.
  */
  initEvents: function() {
    this.getButtons().bind("click", this.handleClickEvent.bind(this));
    $("#" + this.randomizerid_).bind("click", this.randomizeLeftNumbers.bind(this));
    $("#" + this.resetid_).bind("click", this.resetChoices.bind(this));
  },
  
  /**
  * Initialize buttons
  */
  initButtons: function() {
    var number = 0;
    $.each(this.getButtons(), function(i,v) {
      $(v).data("number", ++number);
    });
  },
  
  /**
  * Handle click on a single lottery button.
  * \param Event ev
  */
  handleClickEvent: function(ev) {
    var $target = $(ev.target).closest("a");
    var number = $target.data("number");
          
    if (!$target.hasClass(this.activeclass_) && this.canSetChoice()) {
      this.setChoice(number);
      $target.addClass(this.activeclass_);
    }
    else if ($target.hasClass(this.activeclass_)) {
      $target.removeClass(this.activeclass_);
      this.unsetChoice(number);
    }
  }
}

/**
* freelotto ctor
* \param string buttonclass
* \param string randomize
* \param string resetter
*/
function Freelotto (buttonclass, randomize, resetter) {
  this.buttonclass_ = buttonclass;
  this.randomizerid_ = randomize;
  this.resetid_ = resetter;
  
  this.initButtons();
  this.initEvents();
} 
