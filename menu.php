<aside id="sidebar" class="sidebar c-overflow">
    <div class="s-profile">
        <a href="" data-ma-action="profile-menu-toggle">
            <div class="sp-pic">
                <img src="img/icons/avatar.png" alt="">
            </div>

            <div class="sp-info">
                <?php echo "$_SESSION[UsuarioNome]" ?>
                <i class="zmdi zmdi-caret-down"></i>
            </div>
        </a>

        <ul class="main-menu">
            <li>
                <a href="perfil"><i class="zmdi zmdi-account"></i> Perfil</a>
            </li>
            <li>
                <a href="classes/logout.php"><i class="zmdi zmdi-time-restore"></i> Sair</a>
            </li>
        </ul>
    </div>

    <ul class="main-menu">
        <li><a href="home"><i class="zmdi zmdi-home"></i> Home</a></li>
        
        <?php
            $rotinas = ManagerSession::buscaItensMenu($_SESSION['UsuarioTipo']);
            if($rotinas != "nenhum"){
            foreach ($rotinas as $rotina){
        ?>
        <li class="sub-menu">
            <a href="" data-ma-action="submenu-toggle"><i class="<?php echo $rotina->icon ?>"></i> <?php echo $rotina->nome ?></a>
                <ul>
                    <?php
                            foreach ($rotina->subRotinas as $subRotinas){
                    ?>
                        <li><a href="<?php echo $subRotinas->path ?>"><?php echo $subRotinas->nome ?></a></li>
                    <?php
                            }
                    ?>
                </ul>
        </li> 
        <?php
            }
            }
            
        if($_SESSION['UsuarioTipo'] == 1){
        ?>
        
        <li class="sub-menu">
            <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-settings"></i> Configurações</a>
                <ul>
                    <li><a href="usuarios">Usuários</a></li>
                    <li><a href="tiposUsuario">Perfis de usuário</a></li>
                    <li><a href="rotinas">Rotinas</a></li>
                </ul>
        </li> 

        <?php
            }
        ?>        
    <li><a data-toggle="modal" href="#modalSobre"><i class="zmdi zmdi-info"></i> Sobre</a></li>
    </ul>
</aside>

<aside id="chat" class="sidebar">

    <div class="chat-search">
        <div class="fg-line">
            <input type="text" class="form-control" placeholder="Search People">
            <i class="zmdi zmdi-search"></i>
        </div>
    </div>
    
</aside>

<!-- Modal Default -->
<div class="modal fade" id="modalSobre" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="card" style="">
                    <div class="card-body card-padding">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group fg-line">
                                    <p class="text-center">Mapping Publicidades - Versão 1.0</p>
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <p class="text-center"><img src="img/logo_inovacao.png" style="width: 150px"/></p>
                            </div>                            
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>


