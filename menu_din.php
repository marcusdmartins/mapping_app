<aside id="sidebar" class="sidebar c-overflow">
    <div class="s-profile">
        <a href="" data-ma-action="profile-menu-toggle">
            <div class="sp-pic">
                <img src="fotos/avatar.png" alt="">
            </div>

            <div class="sp-info">
                <?php echo "$_SESSION[UsuarioNome]" ?>
                <i class="zmdi zmdi-caret-down"></i>
            </div>
        </a>

        <ul class="main-menu">
            <li>
                <a href="perfil.php"><i class="zmdi zmdi-account"></i> Perfil</a>
            </li>

            <li>
                <a data-toggle="modal" href="#modalSenha"><i class="zmdi zmdi-settings"></i> Alterar senha</a>
            </li>
            <li>
                <a href="classes/logout.php"><i class="zmdi zmdi-time-restore"></i> Sair</a>
            </li>
        </ul>
    </div>

    <ul class="main-menu">
        <li><a href="home"><i class="zmdi zmdi-home"></i> Home</a></li>

        <li class="sub-menu">
            <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-face"></i> Aluno/ Responsáveis</a>
                <ul>
                    <li class="sub-menu"><a href="" data-ma-action="submenu-toggle"> Aluno</a>
                        <ul>
                            <li><a href="alunos"> Procurar aluno</a></li>
                            <li><a href="alunoNovo"> Novo aluno</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu"><a href="#" data-ma-action="submenu-toggle"> Responsáveis</a>
                        <ul>
                            <li><a href="responsaveis"> Procurar responsável</a></li>
                            <li><a href="responsavelNovo"> Novo responsável</a></li>    
                        </ul>
                    </li>
                </ul>
        </li> 
        
        <li class="sub-menu">
            <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-account"></i> Professores</a>
                <ul>
                    <li><a href="professores">Procurar professor</a></li>
                    <li><a href="professorNovo">Novo professor</a></li>
                </ul>
        </li>        
        
        <li class="sub-menu">
            <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-edit"></i> Personalização</a>
                <ul>
                    <li><a href="niveis">Niveis</a></li>
                    <li><a href="cursos">Cursos</a></li>
                    <li><a href="disciplinas">Disciplinas</a></li>
                    <li><a href="turmas">Turmas</a></li>
                    <li><a href="salas">Salas</a></li>
                    <li><a href="tiposAvaliacao">Tipos de avaliação</a></li>
                </ul>
        </li>
        
         
        
        <li><a href="#"><i class="zmdi zmdi-money"></i>Matrículas</a></li>
        <li><a href="tiposUsuario"><i class="zmdi zmdi-settings"></i>Configurações</a></li>
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
<div class="modal fade" id="modalSenha" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar senha</h4>
            </div>
            <div class="container">
                <form action="classes/login.php" method="POST">
                    <input type="hidden" value="altera_senha" name="function" />
                    <input name="id" type="hidden" value="<?php echo $_SESSION['UsuarioID']; ?>">
                    <div class="form-group fg-line">
                        <input type="password" name="senha_atual" class="form-control input-sm" id="exampleInputEmail1"
                               placeholder="Senha atual">
                    </div>
                    <div class="form-group fg-line">
                        <input type="password" name="nova_senha" class="form-control input-sm" id="exampleInputPassword1"
                               placeholder="Nova senha">
                    </div>
                    <div class="form-group fg-line">
                        <input type="password" name="confirma_senha" class="form-control input-sm" id="exampleInputPassword1"
                               placeholder="Repita a nova senha">
                    </div>
                    <div class="form-group fg-line">
                        <button type="submit" class="btn btn-primary btn-sm m-t-10">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
