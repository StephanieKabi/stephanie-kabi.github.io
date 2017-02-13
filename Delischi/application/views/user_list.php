<?php
if(isset($_SESSION['logged_in_user_id'])) {
  $userid = $this->session->userdata('logged_in_user_id');
  $usertype = $this->session->userdata('usertype');
  $imagename = $this->session->userdata('profile_image');
}
?>

<div class="pageWrap">

  <div class="container">

    <div class="row">

        <section class="panel">

          <div class="panel-heading">
            <h2>Users<?php //echo $panel_title_1; ?></h2>
          </div>

          <div class="panel-body">

            <div class="container">

              <table class="u-full-width">
                <thead>
                  <tr>
										<th></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Account</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($allusers as $row) {
                    echo '
                    <tr>
											<td><img class="userlist-img" src='.base_url()."uploadedImages/profile/".$row->imagepath.'></td>
                      <td>'.$row->firstname.' '.$row->lastname.'</td>
                      <td>'.$row->emailaddress.'</td>
                      <td>'.$row->usertype.'</td>
                    </tr>
                    ';
                  }
                  ?>
                </tbody>
              </table>

            </div>

          </div>

        </section>

    </div>

  </div>

</div>
