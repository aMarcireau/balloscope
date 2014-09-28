/**
 * Balloscope jquery
 *
 * Frontend for the Balloscope app.
 *
 * @author Zboubidoo <zboubidoo@nxtelevision.com>
 * @version 1.0
 */

$(document).ready(function () {
    Balloscope.main();
});


var Balloscope = {

    /**
     * User parameters
     * --------------------------------------------------
     */

        refreshInterval:     5000,
        buttonClass:         "add-two-balls",
        buttonDisabledClass: "disabled",
        buttonErrorClass:    "error",
        ballsCountClass:     "balls-count",
        wheelClass:          "wheel",
        userNameClass:       "user-name",
        ballsCountClass:     "balls-count",
        userContainerClass:  "user-container",
    
    
    /**
     * Properties
     * --------------------------------------------------
     */
    
        ballsByUser:    {},
        preventRefresh: false,
        error:          false,
        loopTimeout:    null,
        interface:      "disabled",
    
    
    /**
     * Methods
     * --------------------------------------------------
     */
        
        /**
         * Main
         *
         */
        main: function() {
            var that = this;
            
            this.curveNames(true);
            $(window).resize(function () {
                that.curveNames(false);
            });
        
            
            this.readHtml();
            this.enableInterface();
            this.refresh({});
        },
        
        
        /**
         * Curve names
         *
         */      
        curveNames: function(initialize) {
            var that = this;
            var computedRadius = $("." + that.userContainerClass).outerWidth() / 2;
            
            if (initialize) {
                $("." + that.userNameClass).arctext({
                    radius: computedRadius
                });
                
                $("." + that.ballsCountClass).arctext({
                    radius: computedRadius,
                    direction: -1
                });
            } else {
                $("." + that.userNameClass).arctext("set", {
                    radius: computedRadius
                });
                
                $("." + that.ballsCountClass).arctext("set", {
                    radius: computedRadius,
                    direction: -1
                });
            }
        },
        
        
        /**
         * Read html data
         *
         */      
        readHtml: function() {
            var that = this;
        
            $("." + this.ballsCountClass).each(function() {
                that.ballsByUser[$(this).attr("id")] = $(this).html();
            });
        },
        
        
        /**
         * Refresh data
         *
         */
        refresh: function(parameters) {
            var that  = typeof parameters.that  !== "undefined" ? parameters.that : this;
            var error = typeof parameters.error !== "undefined" ? parameters.error : false;
            
            if (!that.preventRefresh || error) {
                $.getJSON(Routing.generate('balloscope_core_main_ajaxballsbyuser'))    
                     
                    .done(function(ballsByUser) {
                    
                        if (!that.preventRefresh || error) {
                            if (error) {
                                that.enableInterface();
                            }
                             
                            $.each(ballsByUser, function(userId, ballsNumber) {
                            
                                if (that.ballsByUser[userId] !== ballsNumber) {
                                    that.updateHtml(userId, ballsNumber);
                                    that.ballsByUser[userId] = ballsNumber;
                                }
                            });
                             
                            that.refreshTimeout = setTimeout(function() { that.refresh({that: that}); }, that.refreshInterval);
                        }
                    })
                     
                    .fail(function () {
                        if (!that.preventRefresh || error) {
                            that.errorInterface();
                        }     
                    });
            }
        },
         
         
        /**
         * Update html
         *
         */
        updateHtml: function(userId, ballsNumber) {
            var that = this;
            
            $("#" + userId + "." + that.ballsCountClass).html(ballsNumber);        
        },
         
        
        /**
         * Add two balls
         *
         */
        addTwoBalls: function(userId) {
            var that = this;
            
            if (!that.preventRefresh) {
                that.disableInterface();
    
                $.getJSON(Routing.generate('balloscope_core_main_ajaxaddtwoballs', {id: userId}))
                
                    .done(function(ballsByUser) {
                        that.updateHtml(userId, ballsByUser[userId])
                        that.ballsByUser[userId] = ballsByUser[userId];
                        
                        that.enableInterface();
                        that.refresh({});
                    })
                    
                    .fail(function () { 
                        that.errorInterface();
                    });
            }
        },
        
        
        /**
         * Enable interface
         *
         */
        enableInterface: function() {
            var that = this;
        
            if (that.interface !== "enabled") {
                that.interface = "enabled";
            
                $("." + that.buttonClass).click(function() {
                    that.addTwoBalls($(this).attr("data-id"));
                });
                
                $("." + that.buttonClass).removeClass(that.buttonDisabledClass).removeClass(that.buttonErrorClass);
            }
            
            $("." + that.wheelClass).propeller({inertia: 0.9})
            
            that.preventRefresh = false;
        },
         
         
        /**
         * Enable interface
         *
         */
        disableInterface: function() {
            var that = this;
        
            that.preventRefresh = true;
            clearTimeout(that.refreshTimeout);
            
            if (that.interface !== "disabled") {
                that.interface = "disabled";
            
                $("." + that.buttonClass).unbind("click");
                
                $("." + that.buttonClass).removeClass(that.buttonDisabledClass).removeClass(that.buttonErrorClass);
            }
        },
         
    
        /**
         * Error interface
         *
         */
        errorInterface: function() {
            var that = this;
        
            that.preventRefresh = true;
            clearTimeout(that.refreshTimeout);
            
            if (that.interface !== "error") {
                that.interface = "error";
            }
        
            that.refresh({error: true});
        }
}
