<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Mes uses cases</h3>
    </div>
    <div class="panel-body">
        <?php foreach ($usecases as $usecase) { ?>
            <?php if ($usecase->getidDev() == $author) { ?>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-bottom: 4px;">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading<?php echo $usecase->getCode(); ?>" style="height: 40px;">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $usecase->getCode(); ?>" aria-expanded="false" aria-controls="collapseTwo">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="panel-title">
                                            <?php echo $usecase->getCode(); ?> : <?php echo $usecase->getNom(); ?> [<?php echo $usecase->getPoids(); ?>]
                                        </h4>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="progress" style="background-color: #ffffff">
                                            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $usecase->getAvancement(); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $usecase->getAvancement(); ?>%">
                                                <?php echo $usecase->getAvancement(); ?>%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <?php echo $usecase->getCode(); ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div id="collapse<?php echo $usecase->getCode(); ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $usecase->getCode(); ?>">
                            <div class="panel-body">
                                <br/>
                                <button id="btnMessages" class="btn btn-default">Répondre</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>