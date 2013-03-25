function sendData(callback, target) {
    var option;
    if (callback === "loadCommunity") {
        option = {
            beforeSend: function() {
                showuidfeedback(target);
            },
            success: function(response, statusText, xhr) {
                loadCommunity(response, statusText, target);
            },
            data: {
                param: "community",
                uid: target.uid
            }
        };
    } else if (callback === "loadSuggestCommunity") {
        option = {
            beforeSend: function() {
                showuidfeedback({target: target});
            },
            success: function(response, statusText, xhr) {
                loadSuggestCommunity(response, statusText, target);
            },
            data: {
                param: "sugcomm",
                uid: target.uid
            }
        };
    } else if (callback === "loadSuggestFriends") {
        option = {
            beforeSend: function() {
                showuidfeedback(target);
            },
            success: function(response, statusText, xhr) {
                loadSuggestFriends(response, statusText, target);
            },
            data: {
                param: "sugfriend",
                uid: target.uid
            }
        };
    } else if (callback === "loadGossbag") {
        option = {
            beforeSend: function() {
                showuidfeedback(target);
            },
            success: function(response, statusText, xhr) {
                loadGossbag(response, statusText, target);
            },
            data: {
                param: "gossbag",
                uid: target.uid
            }
        };
    } else if (callback === "loadNotificationCount") {
        option = {
            beforeSend: function() {
            },
            success: function(response, statusText, xhr) {
                loadNotificationCount(response, statusText, target);
            },
            data: {
                param: "notifSum",
                uid: target.uid
            }
        };
    } else if (callback === "loadNavMessages") {
        option = {
            beforeSend: function() {
                showuidfeedback(target);
            },
            success: function(response, statusText, xhr) {
                loadNavMessages(response, statusText, target);
            },
            data: {
                param: "messages",
                uid: target.uid,
                timestamp: target.timestamp
            }
        };
    } else if (callback === "loadFriends") {
        option = {
            beforeSend: function() {
                showuidfeedback(target);
            },
            success: function(response, statusText, xhr) {
                loadFriends(response, statusText, target);
            },
            data: {
                param: "friends",
                uid: target.uid
            }
        };
    } else if (callback === "logError") {
        option = {
            data: {
//                    target.jqXHR
                param: target.param,
                uid: target.uid,
                statusCode: target.jqXHR.status,
                statusText: target.jqXHR.statusText,
                readyState: target.jqXHR.readyState,
                responseText: target.jqXHR.responseText,
                textStatus: target.textStatus,
                errorThrown: target.errorThrown
            }
        };
    }

    $.ajax(option);
}
function showuidfeedback(target) {
    if (target.loadImage)
        $(target.target).html("<center><img src='images/loading.gif' /></center>");
    return true;
}
function loadGossbag(response, statusText, target) {

}
function loadNavMessages(response, statusText, target) {
    var htmlstr = "";
    $.each(response, function(i, response) {
        if (target.target === "#message-individual-notification") {
            htmlstr += '<div class="individual-notification' + ((response.status === "R") ? " viewed-notification" : "") + '"><p><span class="float-right"> 17 hrs </span><div class="clear"></div>' +
                    '</p><img class= "notification-icon" src="' + (response.photo.nophoto ? response.photo.alt : response.photo.thumbnail) + '"><div class="notification-text">' +
                    '<p class="name">' + response.firstname.concat(' ', response.lastname) + '</p><p><!--<span class="icon-16-reply">--></span>' + response.message.substring(0, 30) + (response.message.lenght > 29 ? "..." : "") + '</p>' +
                    '</div><div class="clear"></div><hr><a class="notification-actions">View</a><div class="clear"></div></div>';
        } else {
            htmlstr += '<div class="individual-message-box"><p><span class="all-messages-time"> 17 hrs </span></p>' +
                    '<img class= "all-messages-image" src="' + (response.photo.nophoto ? response.photo.alt : response.photo.thumbnail) + '"><div class="all-messages-text">' +
                    '<a href=""><h3>' + response.firstname.concat(' ', response.lastname) + '</h3></a>' +
                    '<div class="all-messages-message">' + response.message.substring(0, 250) + (response.message.lenght > 249 ? "..." : "") + '</div></div><hr><p>' +
                    '<a class="all-messages-actions"><span class="icon-16-cross"></span>Delete</a>' +
                    '<a href="message-conversation" class="all-messages-actions"><span class="icon-16-reply"></span>Reply</a></p></div>';
        }
    });
    $(target.target).html(htmlstr);
}
function loadNotificationCount(response, statusText, target) {
    if (response.gb > 0) {
        $("#gb-number").html(response.gb);
    } else {
        $("#gb-number").html(" ");
    }
    if (response.msg > 0) {
        $("#msg-number").html(response.msg);
    } else {
        $("#msg-number").html(" ");
    }
    if ((response.gb + response.msg) > 0) {
        document.title = target.title + " (" + (response.gb + response.msg) + ")";
    } else {
        document.title = target.title;
    }
    setTimeout(function() {
        sendData("loadNotificationCount", target);
    }, 60000);
}
function loadCommunity(response, statusText, target) {
    if (!response.error) {
        var htmlstr = "";
        $.each(response, function(i, response) {
            if (target.target === "#aside-community-list") {
                htmlstr += '<div class="community-listing"><span><a href="">' + response.name + '</a></span></div><hr>';
            } else if (target.target === ".community-box") {
                htmlstr += '<div class="community-box-wrapper"><div class="community-image">' +
                        '<img src="' + response.pix + '">' +
                        '</div><div class="community-text"><div class="community-name">' +
                        '<a href="sample-community">' + response.name + '</a> </div><hr><div class="details">' + response.description +
                        '</div><div class="members">200 Members</div><div class="members">200 Posts</div></div><div class="clear"></div></div>';
            }
        });
        $(target.target).html(htmlstr);
    } else {
        if (response.error.code === 404) {
            $("#pageTitle").html("Sugested Community");
            sendData("loadSuggestCommunity", target);
        } else {
            humane.log(response.error.message, {timeout: 20000, clickToClose: true, addnCls: 'humane-jackedup-error'});
        }
    }
}
function loadSuggestCommunity(response, statusText, target) {
    if (!response.error) {
        var htmlstr = "";
        $.each(response, function(i, response) {
            if (target.loadImage) {
                htmlstr += '<div class="community-box-wrapper">';
                htmlstr += '<div class="community-image"><img src="' + response.pix + '"></div>';
                htmlstr += '<div class="community-text"><div class="community-name">' +
                        '<a href="sample-community">' + response.name + '</a> </div><hr><div class="details">' + response.description +
                        '</div><div class="members">200 Members</div><div class="members">200 Posts</div></div><div class="clear"></div></div>';
            } else {
                if (i > 0) {
                    htmlstr += '<hr>';
                }
                htmlstr += '<div class="community-listing"><span><a href="">' + response.name + '</a></span></div>';
            }
        });
        $(target.target).html(htmlstr);
    } else {
        if (response.error.code === 404) {
            if (target.loadImage) {
                $("#pageTitle").html("Sugested Community");
            }
            $(target.target).html("<p>Opps! We cannot suggest community to you at the moment. <a href='communities.php'>Start your own community</a>.</p>");
        } else {
            $("#pageTitle").html("Communities");
            humane.log(response.error.message, {timeout: 20000, clickToClose: true, addnCls: 'humane-jackedup-error'});
        }
    }
}
function loadFriends(response, statusText, target) {
    if (!response.error) {
        var htmlstr = "";
        $.each(response, function(i, responseItem) {
            if (target.target === "#aside-friends-list") {
                htmlstr += '<a class= "fancybox " id="inline" href="#' + responseItem.username + '">' +
                        '<img class= "friends-thumbnails" src="' + (responseItem.photo.nophoto ? responseItem.photo.alt : responseItem.photo.thumbnail) + '">' +
                        '<div style="display:none"><div id="' + responseItem.username + '"><div class="aside-wrapper">' +
                        '<img class="profile-pic" src="' + (responseItem.photo.nophoto ? responseItem.photo.alt : responseItem.photo.thumbnail) + '"><table><tr><td></td><td>' +
                        '<h3>' + responseItem.firstname.concat(" ", responseItem.lastname) + '</h3></td></tr><tr><td><span class="icon-16-map"></span></td><td class="profile-meta">' + responseItem.location + '</td></tr>' +
                        '<tr><td><span class="icon-16-' + (responseItem.gender === "M" ? "male" : "female") + '"></span></td><td class="profile-meta">' + (responseItem.gender === "M" ? "Male" : "Female") + '</td></tr>' +
                        '<tr><td><span class="icon-16-dot"></span></td><td class="profile-meta"><a href="">See Profile</a> </td></tr></table>' +
                        '<div class="clear"></div><button class="profile-meta-functions button"><span class="icon-16-eye"></span> Wink</button>' +
                        '<button class="profile-meta-functions button"><span class="icon-16-mail"></span> Send Message</button>' +
                        '<button class="profile-meta-functions button"><span class="icon-16-checkmark"></span> Accept Friendship</button>' +
                        '<div class="clear"></div></div></div></div></a>';
            } else {

            }
        });
        $(target.target).html(htmlstr);
    } else {
        if (response.error.code === 404) {
            $(target.target).html("<p>Opps! We cannot suggest friends to you at the moment. <a href='communities.php'>Join a community</a> to increase your chances.</p>");
        } else {
            $("#pageTitle").html("Communities");
            humane.log(response.error.message, {timeout: 20000, clickToClose: true, addnCls: 'humane-jackedup-error'});
        }
    }
}
function loadSuggestFriends(response, statusText, target) {
    if (!response.error) {
        var htmlstr = "";
        $.each(response, function(i, response) {
            htmlstr += '<div class="individual-friend-box"><a class= "fancybox" id="inline" href="#' + response.username + '"><div class="friend-image">';
            if (response.photo.id) {
                htmlstr += '<img src = "' + (response.photo.thumbnail === "" ? response.photo.original : response.photo.thumbnail) + '" >';
            } else {
                htmlstr += '<img src = "' + response.photo.nophoto + '" >';
            }
            htmlstr += '</div><div class="friend-text"><div class="friend-name">' + response.firstname.concat(" ", response.lastname) + '</div>' +
                    '<div class="friend-location">' + response.location + '</div></div>';
            htmlstr += '<div style="display:none"><div id="' + response.username + '"><div class="aside-wrapper">';
            if (response.photo.id) {
                htmlstr += '<img class="profile-pic" src = "' + (response.photo.thumbnail === "" ? response.photo.original : response.photo.thumbnail) + '" >';
            } else {
                htmlstr += '<img class="profile-pic" src = "' + response.photo.nophoto + '" >';
            }
//
            htmlstr += '<div class="clear"></div><table><tr><td></td><td><h3>' + response.firstname.concat(" ", response.lastname) + '</h3></td></tr>' +
                    '<tr><td><span class="icon-16-map"></span></td><td class="profile-meta"> ' + (response.location !== "" ? response.location : "Location not set") + '</td></tr>' +
                    '<tr><td><span class="icon-16-' + (response.gender === "M" ? "male" : "female") + '"></span></td><td class="profile-meta"> ' + (response.gender === "M" ? "Male" : "Female") + '</td></tr>' +
//                    '<tr><td><span class="icon-16-dot"></span></td><td class="profile-meta"><a href="#">See Profile</a> </td></tr>' +
                    '</table><div class="profile-summary profile-summary-width"><div class="profile-summary-wrapper">' +
                    '<a href=""><p class="number">50 </p> <p class="type">Posts</p></a></div>' +
                    '<div class="profile-summary-wrapper"><a href="communities"><p class="number">30 </p> <p class="type">Communities</p></a></div>' +
                    '<div class="profile-summary-wrapper"><a href="friends"><p class="number">50 </p> <p class="type">Friends</p></a></div>' +
                    '<div class="clear"></div></div>' +
                    '<button class="profile-meta-functions button"><span class="icon-16-eye"></span> Wink</button>' +
                    '<div class="clear"></div></div></div></div>';
            htmlstr += '</a></div>';
        });
        $(target.target).html(htmlstr);
    } else {
        if (response.error.code === 404) {
            $(target.target).html("<p>Opps! We cannot suggest friends to you at the moment. <a href='communities.php'>Join a community</a> to increase your chances.</p>");
        } else {
            $("#pageTitle").html("Communities");
            humane.log(response.error.message, {timeout: 20000, clickToClose: true, addnCls: 'humane-jackedup-error'});
        }
    }
}
function manageError(jqXHR, textStatus, errorThrown, option) {
    humane.log("Something unexpected just happened!... Our team are on it alreay!", {timeout: 20000, clickToClose: true, addnCls: 'humane-jackedup-error'});
    option = {
        uid: option.uid,
        param: "logError",
        jqXHR: jqXHR,
        textStatus: textStatus,
        errorThrown: errorThrown
    };
    sendData("logError", option);
}
function showOption(obj) {
    var option;
    if (obj.id === "show-suggested-friends") {
        $("#pop-up-gossbag").toggle(false);
        $("#pop-up-message").toggle(false);
        $("#pop-up-user-actions").toggle(false);
        $("#pop-up-more").toggle(false);
        if ($("#" + obj.id).hasClass("Open")) {
            $("#" + obj.id).removeClass("Open");
            $("#" + obj.id).html("Suggest Friends");
        } else {
            $("#" + obj.id).addClass("Open");
            $("#" + obj.id).html("Hide Suggested Friends");
        }
        option = {
            complete: function() {
                if (!$(this).hasClass("loadedContent")) {
                    sendData("loadSuggestFriends", {uid: readCookie("user_auth"), target: "#aside-suggest-friends", loadImage: true});
                    $(this).addClass("loadedContent");
                }
            }
        };
        $("#suggested-friends").toggle(option);
    } else if (obj.id === "show-suggested-community") {
        if ($("#" + obj.id).hasClass("Open")) {
            $("#" + obj.id).removeClass("Open");
            $("#" + obj.id).html("Suggest Community");
        } else {
            $("#" + obj.id).addClass("Open");
            $("#" + obj.id).html("Hide Suggested Community");
        }
        option = {
            complete: function() {
                if (!$(this).hasClass("loadedContent")) {
                    sendData("loadSuggestCommunity", {uid: readCookie("user_auth"), target: "#aside-suggest-community", loadImage: false});
                    $(this).addClass("loadedContent");
                }
            }
        };
        $("#suggested-community").toggle(option);
    } else if (obj.id === "gossbag-text" || obj.id === "gossbag-close") {
        $("#pop-up-message").toggle(false);
        $("#pop-up-user-actions").toggle(false);
        $("#pop-up-more").toggle(false);
        $("#pop-up-gossbag").toggle();
    } else if (obj.id === "messages-text" || obj.id === "messages-close") {
        $("#pop-up-gossbag").toggle(false);
        $("#pop-up-user-actions").toggle(false);
        $("#pop-up-more").toggle(false);
        option = {
            complete: function() {
                if ($("#" + obj.id).hasClass("Open")) {
                    if (!$("#" + obj.id).hasClass("loaded")) {
                        $("#" + obj.id).addClass("loaded");
                        sendData("loadNavMessages", {uid: readCookie("user_auth"), target: "#message-individual-notification", loadImage: true});
                    }
                }
            },
            duration: 0
        };
        if ($("#" + obj.id).hasClass("Open")) {
            $("#" + obj.id).removeClass("Open");
        } else {
            $("#" + obj.id).addClass("Open");
        }
        $("#pop-up-message").toggle(option);
    } else if (obj.id === "user-actions") {
        $("#pop-up-gossbag").toggle(false);
        $("#pop-up-message").toggle(false);
        $("#pop-up-more").toggle(false);
        $("#pop-up-user-actions").toggle();
    } else if (obj.id === "user-more-option") {
        $("#pop-up-gossbag").toggle(false);
        $("#pop-up-message").toggle(false);
        $("#pop-up-user-actions").toggle(false);
        $("#pop-up-more").toggle();
    } else if (obj.id === "show-full-profile") {
        $("#pop-up-gossbag").toggle(false);
        $("#pop-up-message").toggle(false);
        $("#pop-up-user-actions").toggle(false);
        $("#pop-up-more").toggle(false);
        if ($("#" + obj.id).hasClass("Open")) {
            $("#" + obj.id).removeClass("Open");
            $("#" + obj.id).html("View Full Profile");
        } else {
            $("#" + obj.id).addClass("Open");
            $("#" + obj.id).html("Hide Full Profile");
        }
        $("#full-profile-data").toggle();
    } else if (obj.id === "search" || obj.id === "search-close") {
        $("#pop-up-gossbag").toggle(false);
        $("#pop-up-message").toggle(false);
        $("#pop-up-user-actions").toggle(false);
        $("#pop-up-more").toggle(false);
        $("#full-profile-data").toggle(false);
        $("#pop-up-search").toggle();
    }
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0)
            return c.substring(nameEQ.length, c.length);
    }
    return 0;
}