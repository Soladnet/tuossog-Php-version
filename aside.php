<?php
$countStat = isset($user) ? $user->getMiniStat() : array("fc" => 0, "cc" => 0, "pc" => 0);
?>
<div class="aside">
    <div class="aside-wrapper">
        <img class="profile-pic" src="<?php echo isset($userProfile['user']['photo']['nophoto']) ? $userProfile['user']['photo']['alt'] : $userProfile['user']['photo']['thumbnail'] ?>">

        <table>
            <tr><td colspan="2"><h3><a href=""><?php echo isset($user) ? $user->getFullname() : "GUEST"; ?></a></h3></td></tr>
            <tr><td><span class="icon-16-map"></span></td><td class="profile-meta"><?php echo isset($user) ? $user->getLocation() != "" ? $user->getLocation() : "Set your location"  : ""; ?></td></tr>
            <!--<tr><td><span class="icon-16-female"></span></td><td class="profile-meta">Joined on Feb 18, 2013 </td></tr>-->
            <tr><td><span class="icon-16-male"></span></td><td class="profile-meta"><?php echo isset($user) ? $user->getGender() == "M" ? "Male" : "Female"  : "N/A"; ?></td></tr>
            <tr><td><span class="icon-16-dot"></span></td><td class="profile-meta"><a id="show-full-profile" > View Full Profile</a> </td></tr>
        </table>					
        <div class="clear"></div>
        <div class="profile-summary">
            <div class="profile-summary-wrapper"><a href=""><p class="number"><?php echo isset($user) ? $user->getMiniStat("pc") : "0" ?></p> <p class="type">Posts</p></a></div>
            <div class="profile-summary-wrapper"><a href="communities"><p class="number"><?php echo isset($user) ? $user->getMiniStat("cc") : "0" ?></p> <p class="type">Communities</p></a></div>
            <div class="profile-summary-wrapper"><a href="all-friends"><p class="number"><?php echo isset($user) ? $user->getMiniStat("fc") : "0" ?></p> <p class="type">Friends</p></a></div>
            <div class="clear"></div>
        </div>
        <!--<div class="clear"></div>-->
<!--        <button class=" button profile-button"><span class="icon-16-mail"></span> Message</button>
        <button class=" button profile-button" id="user-more-option">More<span class="icon-16-checkmark"></span>
            <div class="more-container" id="pop-up-more">
                <div class="more">
                    <ul>
                        <li><a href=""><span class="icon-16-eye"></span> Wink</a></li>
                        <li><a href=""><span class="icon-16-mail"></span> Message</a></li>
                        <li><a href=""><span class="icon-16-checkmark"></span> Favourite</a></li>
                        <hr>
                        <li><a href=""><span class="icon-16-checkmark"></span> Mute</a></li>
                        <li><a href=""><span class="icon-16-cross"></span> Delete</a></li>
                    </ul>
                </div>
            </div>

        </button>-->

        <div class="clear"></div>
        <div id="full-profile-data" class="no-display">
            <hr>
            <b>More Information</b>
            <table class="profile-meta " colspan="1" width="100%">
                <!--<tr><td>Name</td><td>Ciroma Chukwuma Adekunle <td></tr>-->
                <tr><td><strong>Email</strong></td><td><?php echo isset($user) ? $user->getEmail() : ""; ?><td></tr>
                <!--<tr><td>Gender</td><td>Male<td></tr>-->
                <tr><td><strong>Birthday</strong> </td><td><?php echo isset($user) ? $user->getDOB() : ""; ?><td></tr>
                <!--<tr><td>Relationship</td><td>Single<td></tr>-->
                <tr><td><strong>Phone</strong></td><td><?php echo isset($user) ? $user->getTel() : ""; ?><td></tr>
                <tr><td><strong>Website</strong></td><td><?php echo isset($user) ? $user->getUrl() : ""; ?><td></tr>
            </table>
            <hr>
            <p><b>Location</b></p>
            <!--<iframe width="300" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.ng/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Abuja,+Abuja+Capital+Territory,+Nigeria&amp;aq=0&amp;oq=abuja,+niger&amp;sll=9.033872,8.677457&amp;sspn=11.762511,21.643066&amp;ie=UTF8&amp;hq=&amp;hnear=Abuja,+Abuja+Capital+Territory&amp;t=m&amp;ll=9.066839,7.482376&amp;spn=0.20342,0.136642&amp;z=11&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com.ng/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Abuja,+Abuja+Capital+Territory,+Nigeria&amp;aq=0&amp;oq=abuja,+niger&amp;sll=9.033872,8.677457&amp;sspn=11.762511,21.643066&amp;ie=UTF8&amp;hq=&amp;hnear=Abuja,+Abuja+Capital+Territory&amp;t=m&amp;ll=9.066839,7.482376&amp;spn=0.20342,0.136642&amp;z=11&amp;iwloc=A" style="color:#0000FF;text-align:left">View Larger Map</a></small>-->

            <hr>
            <p><b>College</b></p>
        </div>
    </div>

    <div class="aside-wrapper">
        <h3><a href="communities">Communities</a></h3>
        <?php
//        $comListMin = $userCom->userComm(0, 5);
//        if ($comListMin['status']) {
//            foreach ($comListMin['community_list'] as $comList) {
                ?>
                <span id="aside-community-list"></span>
                <?php
//            }
//        }
        ?>
        <p class="community-listing">
            <span>
                <?php
                if ($countStat['cc'] > 5) {
                    ?>
                    <span><span class="icon-16-dot"></span><a href="communities">Show all</a></span>
                    <?php
                }
                ?>
                <span><span class="icon-16-dot"></span><a id="show-suggested-community">Suggest Communities</a></span>
            </span>
        </p>
    </div>
    <div id= "suggested-community" class="no-display aside-wrapper" > 
        <h3>Suggested Community </h3>
        <span id="aside-suggest-community">
        </span>
    </div>
    <div class="aside-wrapper">
        <h3><a href="friends">Friends</a></h3>
        <script>
            $(document).ready(function() {
                sendData("loadFriends", {target: "#aside-friends-list", uid: readCookie('user_auth'), loadImage: true});
                sendData("loadCommunity", {target: "#aside-community-list", uid: readCookie('user_auth'), loadImage: true});
            });

        </script>
        <span id="aside-friends-list"></span>
        <p class="community-listing">
            <span>
                <?php
                if ($countStat['fc'] > 6) {
                    ?>
                    <span><span class="icon-16-dot"></span><a href="friends">Show all</a></span>
                    <?php
                }
                ?>
                <span><span class="icon-16-dot"></span><a id="show-suggested-friends">Suggest Friends</a></span>

            </span>
        </p>
    </div>
    <?php
    include("suggested-friends.php");
    ?>
    <div class="aside-wrapper" id="abc">
        <!--        <h3>Trends</h3>
                <p><a>#newGossout</a></p>
                <p><a>#newGossout</a></p>
                <p><a>#newGossout</a></p>
                <p><a>#newGossout</a></p>
                <p><a>#newGossout</a></p>
                <p class="community-listing">
                    <span>
                        <span><span class="icon-16-dot"></span><a href="">Show all</a></span>
                    </span>
                </p>-->
    </div>

</div>	