<section class="col-md-5">
    <?php if (isset($_SESSION['alert'])): ?>
    <div class="alert alert-<?=$_SESSION['alert']['error'];?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Aviso!</strong> <?php echo $_SESSION['alert']['message']; unset($_SESSION['alert'])?>
    </div>
    <?php endif;?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?=isset($edit)? "Editar Aluno": "Cadastro de Alunos";?></h3>
        </div>
        <div class="panel-body">
            <form action="" method="post" data-submit="<?=isset($edit)? 'edit': 'create'?>" id="alunos-form">
                <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                <div class="form-group form-group-lg ficha-field">
                    <label for="ficha">Número da Ficha</label>
                    <input type="number" value="<?=$form['ficha']?>" name="ficha" class="form-control ficha" placeholder="Número" required autofocus>
                    <span class="alert-error-form">Já existe uma ficha com esse número!</span>
                </div>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" value="<?=$form['nome']?>" name="nome" class="form-control" placeholder="Nome do Aluno" required>
                </div>
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="text" value="<?=$form['data_nascimento']?>" name="data_nascimento" class="form-control date" placeholder="dd/mm/aaaa" required>
                </div>
                <div class="form-group">
                    <label for="pai">Nome do Pai</label>
                    <input type="text" value="<?=$form['pai']?>" name="pai" class="form-control" placeholder="Nome do Pai">
                </div>
                <div class="form-group">
                    <label for="mae">Nome do Mãe</label>
                    <input type="text" value="<?=$form['mae']?>" name="mae" class="form-control" placeholder="Nome do Mãe" required>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-default btn-lg aluno-submit" type="submit" title="Salvar"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> Salvar</button>
                    <?php if (isset($edit)):?>
                        <a href="<?=self::link('alunos')?>" class="btn btn-default" title="Cancelar"><i class="fa fa-ban fa-lg" aria-hidden="true"></i> Cancelar</a>
                    <?php endif;?>
                </div>
            </form>
        </div>
    </div>
</section>
<section class="col-md-7">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Pesquisar por Alunos</h3>
        </div>
        <div class="panel-body">
            <form action="<?=self::link('alunos/pesquisar');?>" method="post">
                <input type="hidden" value="<?=System\Utilities::token();?>" name="token">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" minlength="3" placeholder="Nome do Aluno" required>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-search fa-lg" aria-hidden="true"></i></button>
                    </span>
                </div>
            </form>
        </div>
        <table class="table table-striped table-hover table-condensed">
            <thead>
                <tr>
                    <th>Ficha</th>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data as $tupla):
                ?>
                <tr>
                    <td><?=sprintf('%04d', $tupla->ficha)?></td>
                    <td><?=$tupla->nome?></td>
                    <td><?=date('d/m/Y', strtotime($tupla->data_nascimento))?></td>
                    <td>                            
                        <div class="btn-group" role="group">
                            <a href="<?=self::link('alunos/editar/'.$tupla->id)?>" class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></i></a>
                            <a href="<?=self::link('alunos/apagar/'.$tupla->id)?>" class="btn btn-danger btn-xs delete" title="Remover"><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <?php if ($_SESSION['alunos']['count'] > 1 && empty($_SESSION['alunos']['search'])):?>
        <nav aria-label="page navigation" class="text-center">
            <ul class="pagination pagination-sm">
                <li>
                    <a href="<?=self::link('alunos/pagina/1')?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li<?=$_SESSION['alunos']['current_page'] == 1? ' class="active"': ''?>>
                    <a href="<?=self::link('alunos/pagina/1')?>">1</a>
                    </a>
                </li>
                
                <?php for ($i = 2; $i <= $_SESSION['alunos']['count'] - 1; $i++):?>
                <li <?=$_SESSION['alunos']['current_page'] == $i? 'class="active"': ''?>><a href="<?=self::link('alunos/pagina/'.$i);?>"><?=$i?></a></li>
                <?php endfor; ?>

                <li<?=$_SESSION['alunos']['current_page'] == $_SESSION['alunos']['count']? ' class="active"': ''?>>
                    <a href="<?=self::link('alunos/pagina/'.$_SESSION['alunos']['count'])?>"><?=$_SESSION['alunos']['count']?></a>
                    </a>
                </li>
                <li>
                    <a href="<?=self::link('alunos/pagina/'.$_SESSION['alunos']['count'])?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
        <?php endif;?>
        <?php if (isset($_SESSION['alunos']['search'])): unset($_SESSION['alunos']['search']);?>
            <div class="text-center">
                <a href="<?=self::link('alunos');?>" class="btn btn-primary" style="margin-bottom: 2rem;margin-top: 2rem;">Mostrar todos</a>
            </div>
        <?php endif;?>
    </div>
</section>