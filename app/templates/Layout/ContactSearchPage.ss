<div class="clearfix">
    $ContactSearchForm
</div>

<h3>Results</h3>
<% loop $Results %>
    <ul>
        <li><a href="contact?id=$ID">$ID</a></li>
        <li>$Name</li>
        <li>$Address</li>
        <li>$Email</li>
        <li>$Phone</li>
    </ul>
<% end_loop %>