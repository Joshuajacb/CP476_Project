<div id="sidebar">
    <div class="sidebar-header">
        <h3><?php echo $_SESSION['username']; ?>'s Channel List</h3>
        <strong>JJ</strong>
    </div>

    <ul id="sidebar_channel_list" class="list-unstyled components">

        <?php

            foreach($_SESSION['channel_list'] as $id => $name) {
                echo '<li class="" id="channel_item" data-channelid="' . $name[0] . '"><a href="" class="channel_list_'. $name[0] . '"><i class="fas fa-book"></i>'. $name[1] . '</a></li>';
            }

            
        ?>

    </ul>
   <!--  
    <div class="joinChannel text-center">
        <button type="button" data-userid="<?php echo $_SESSION['id']; ?>" id="join_channel" class="btn btn-primary btn-sm">Join Channel</button>
    </div> -->
    <div class="addChannel text-center">
        <button type="button" data-toggle="modal" data-target="#newChannelModal"data-userid="<?php echo $_SESSION['id']; ?>" id="create_channel" class="btn btn-primary btn-sm">Create Channel</button>
    </div>


    <div class="expandButton" id="sidebarCollapse">
        <h3><i class="fas fa-arrow-left"></i> Collapse</h3>
        <strong><i class="fas fa-arrow-right"></i></strong>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="newChannelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Channel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="channelName">Channel Name</label>
                        <input type="channelName" name="create_chname" class="form-control send_create_channel" id="create_chname" placeholder="Enter channel name">
                    </div>
                    
                    <button id="create_channel_btn" name="new_channel_button" type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

