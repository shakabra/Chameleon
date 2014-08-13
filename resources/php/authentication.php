<?php
namespace authentication;


/**
 * Print the HTML part of the user authentication interface.
 *
 * @param array $mods An associative array of modifications to the base
 * template markup.
 */
function print_authenticator($mods=null) {
    $class = 'authenticator';
    $class .= ' col-md-4';
    $action = '/resources/php/request_handler.php';
    $method = 'POST';
    $html = <<<EOT
<div class="$class">
  <form action="$action" method="$method">
    <table>
      <tr><td>Username: </td><td><input type="text" name="username"></input></td></tr>
      <tr><td>Password: </td><td><input type="password" name="password"></input></td></tr>
      <tr><td><input type="submit" value="login"></input></td></tr>
    </table>
    <input type="hidden" name="type" value="login">
  </form>
</div>
EOT;
    print($html);
}

/**
 * Look in the database to validate credentials.
 */
function valid_login($username, $password) {
    return True;
}

function generate_token() {
    return 'tokenstring2';
}
