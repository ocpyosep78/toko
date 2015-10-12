<?php $infouser=datauser();?>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
           <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url('gudang');?>">Dashboard <?php echo $infouser['jabatan'];?></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="badge"><?php 
                    $jmlnot=array();$kosong=array();
                    if ($notifs) {
                         if (count($notifs)>0) {
                        foreach ($notifs as $valnof) {
                            if ($valnof['r']==='1'){
                                    $jmlnot[]=$valnof['id'];
                            }else{
                                    $kosong[]=$valnof['id'];
                            }
                        }
                        if ((count($jmlnot)>0) && (count($kosong)===0)) {
                            echo('0');    
                        }else{
                            if (isset($_GET['id'])) {
                                $idnya=htmlspecialchars($_GET['id']);
                                $query=$this->db->where('id',$idnya)
                                        ->update('notif',array('r'=>'1'));
                                if (!$query) {
                                    echo('error');
                                }
                            }
                            echo(count($kosong));
                        }
                    }else{
                        echo('0');
                    }
                    }else{
                        echo('0');
                    }
                 ?>
                </span>
                    <i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                    <?php if ($notifs) { ?>
                                            <?php foreach ($notifs as $key => $vnot) { ?>
                        <li>
                            <?php 
                            $pecahurl=explode('/', current_url());
                            if (count($pecahurl)===6): ?>
                            <a href="<?php echo(current_url().'?id='.$vnot['id'].'&tbl=4');?>">
                            <?php else :?>
                            <a href="<?php echo(current_url().'/a?id='.$vnot['id'].'&tbl=4');?>">
                            <?php endif; ?>
                            From  <?php echo(getuname($vnot['from']));?><span class="<?php echo($vnot['r']==='1')? 'label label-default': 'label label-danger'; ?>">details</span></a>
                        </li>
                    <?php }?>
                    <?php }else{ ?>
                        <li>
                            <a href="#">
                            Belum ada Notifikasi
                            </a>
                        </li>
                    <?php } ?>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo(site_url('gudang/slug/2/4/4'))?>">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>&nbsp<?php echo $infouser['username']; ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo site_url('gudang/profile');?>"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="<?php echo (site_url('gudang/slug/2/4/15'));?>"><i class="fa fa-fw fa-envelope"></i>Inbox</a> <!--<span class="badge">14</span>-->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo base_url('gudang/logout');?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <?php 
                    if (count($menu)===0) { ?>
                        <li><a href="#" >menu tak tersedia</a></li>
                    <?php }else{ ?>
                    <?php foreach ($menu as $row)://$row->title;?>
                    <?php
                    $url=$this->uri->segment(3);
                    if($url==$row['idmenu'] && $this->uri->segment(2)==='page'){
                        $classs='class="active"';
                    }else{
                        $classs='';
                    }
                    ?>
                <?php if (submenu($row['idmenu'])):?>
                        <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="<?php echo('#m'.$row['idmenu']);?>"><i class="fa fa-fw fa-arrows-v"></i><?php echo ucwords($row['menu']);?><i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="<?php echo('m'.$row['idmenu']);?>" class="collapse">
                            <?php $submenu=submenu($row['idmenu']);
                                $jml=count($submenu);
                            ?>
                            <?php for ($m=0; $m < $jml; $m++) {?>
                                <li>
                                    <a href="<?php echo site_url('gudang/slug/'.$row['idmenu'].'/4/'.$submenu[$m]);?>"><?php echo namemenu($submenu[$m]);?></a>
                                </li>
                            <?php  }?>
                            </ul>
                    </li>
                <?php else:?>
                    <li <?php echo $classs;?>>
                        <a href="<?php echo site_url('gudang/slug/'.$row['idmenu'].'/4/'.getmngsinglem($row['idmenu']));?>"><i class="<?php echo $row['icon'];?>"></i><?php echo ucwords($row['menu']);?></a>
                    </li>
                <?php endif;?>
                    <?php endforeach;?>
                    <?php }?>
                    <!--<li class="active">
                        <a href=""><i class="fa fa-fw fa-file"></i> Blank Page</a>
                    </li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
