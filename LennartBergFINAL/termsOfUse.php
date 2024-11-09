<!DOCTYPE html>
<html lang="en">
<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($abs_path)) {
    require_once "path.php";
}

$pageTitle = "TermsOfUse";
require 'php/include/head.php';
?>
<link rel="stylesheet" type="text/css" href="./assets/css/termsOfUse.css">
</head>
<body>
<?php
require 'php/include/nav.php';
?>
<main>
    <h1> Terms of Use</h1>
    <p><strong>§ 1 Scope of Application</strong></p>
    <p>(1) The following conditions apply to the use of Köksbooks - hereinafter referred to as "Our Website" - Forums.
        It is important for you as a user to accept the following forum rules or conditions. Registration and use of our
        forum are free of charge.</p>
    <p>(2) By registering, you agree to the terms of use of our website. By your agreement, you guarantee us that you
        will not create posts that violate the terms of use.</p>
    <p>(3) By using our website, no contract is concluded between the users and us.</p>
    <p><strong>§ 2 Duties as a Forum User</strong></p>
    <p>(1) One of your duties as a user is not to publish posts that violate these forum rules, good morals, or other
        applicable German law.</p>
    <p><span style="text-decoration: underline;">The following points are not permitted:</span></p>
    <p>1. To publish content that is untrue and whose publication fulfills a criminal offense or a regulatory
        offense,<br/>2. Sending spam through the forum to other forum users,<br/>3. Use of legally protected content by
        copyright and trademark law without lawful authorization (e.g., press releases, etc.),<br/>4. Actions that are
        anti-competitive,<br/>5. Posting the same topics multiple times in the forum (so-called double postings),<br/>6.
        Conducting covert advertising, and<br/>7. Publishing content that is offensive, racist, discriminatory, or
        contains pornographic elements against other users and the public.</p>
    <p>It is your duty as a forum user to consider § 2 Para. 1 No. 1-7 of these terms of use before publishing your post
        in the forum and to check whether you have adhered to these points.</p>
    <p>(2) Should you violate § 2 Para. 1 No. 1-7 of these terms of use, we reserve the right to take the following
        steps against you:</p>
    <p>1. To delete your posts and modify them,</p>
    <p>2. Prohibit you from writing posts in the forum, and</p>
    <p>3. Blocking your access as a user.</p>
    <p>(3) If you as a forum user have not followed the forum rules and this has resulted in possible legal violations
        caused by your posts in our forum (breach of duty), you as a user agree to indemnify us from any claims,
        including claims for damages, and to reimburse the costs.</p>
    <p>In addition, the user is obligated to assist us in defending against the legal claims arising from the violation
        of duty (breach of duty as mentioned above), and to bear the costs of an appropriate legal defense for us.</p>
    <p>(4) By your agreement, you guarantee us that you will not create posts that violate the terms of use. The same
        applies to setting external links and signatures.</p>
    <p><strong>§ 3 Transfer of Usage Rights</strong></p>
    <p>You, as a forum user, have the sole responsibility of copyright as per the Copyright Act when publishing posts
        and topics in the forum. (2) As a user, you grant us the right to permanently make your post available for
        retrieval by publishing it on our homepage. (3) Furthermore, our team has the right to delete, edit, and move
        your topics and posts within its homepage to link them with other content or to close them.</p>
    <p><strong>§ 4 Limitation of Liability</strong></p>
    <p>(1) We assume no liability for the posts, topics, external links, and the resulting content published in the
        forum, especially not for their accuracy, completeness, and timeliness. We are also not obligated to
        continuously monitor the transmitted and stored contributions of the users for illegal content. We are generally
        only liable in the case of intentional or grossly negligent breach of duty.</p>
    <p>(2) We expressly point out that the legal posts and discussions in the forum are completely non-binding. (2) The
        use of the posts and their utilization is at your own risk.</p>
    <p>(3) We assume no liability for the content and accuracy of advertisements. (2) The respective author is solely
        responsible for the content of the advertisements; the same applies to the content of the advertised website.
        (3) By displaying the advertisement on our website, we are not simultaneously agreeing to the unlawful content.
        (4) Therefore, liability lies exclusively with the advertiser.</p>
    <p>(4) We do not guarantee constant, uninterrupted access to the website. (2) Liability in this regard is hereby
        expressly contradicted. (3) Even with great care, downtimes cannot be completely excluded.</p>
    <p><strong>§ 5 Copyright</strong></p>
    <p>All texts, images, and other information and data published on our website are subject to copyright - unless
        otherwise indicated - of our site. Any form of reproduction and/or modification may only occur with written
        permission from us. Otherwise, we reserve the right to take legal action against this infringement. (4) All
        costs caused by a copyright infringement by a user will be billed to them.</p>
    <p><strong>§ 6 Reservation of the Right to Modify</strong></p>
    <p>We reserve the right to change the terms of use at any time. The change will then be published via a forum entry
        on the website.</p>
    <p><strong>§ 7 Termination and Duration of Membership on Our Website<br/></strong></p>
    <p>The duration of membership begins with registration and with the agreement to our terms of use and lasts for an
        indefinite period. Membership can be terminated at any time without notice.</p>
    <p><strong>§ 8 Severability Clause</strong></p>
    <p>This forum usage condition is to be considered as part of our website from which this page is referenced. If
        individual formulations of this forum usage condition are no longer entirely or not completely compliant with
        the current legal situation, it is to be assumed that the remaining provisions of the forum usage conditions
        remain in effect.</p>
    <p>These <a href="https://www.jurarat.de/muster-nutzungsbedingungen">terms of use</a> were kindly provided by
        www.jurarat.de.
    </p>
    </div>
    <?php
    require './php/include/foot.php';
    ?>
</body>
</html>
