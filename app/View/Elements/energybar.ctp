<?php 
$energyhours = isset($user_settings['energy_hours']) ? $user_settings['energy_hours'] : 0; ?>
<div class="settings_top_container">
    <div class="settings_container">
        <div class="fleft invisible" >Misc Icons will be here.</div>
        <div class="fright filtercontainer">
            <div class="fright"><a class="jQbutton" id="weekly"><?php echo __("FILTER_WEEK")?></a></div>
            <div class="fright"><a class="jQbutton " id="monthly"><?php echo __("FILTER_MONTH")?></a></div>
            <div class="fright"><a class="jQbutton " id="yearly"><?php echo __("FILTER_YEAR")?></a></div>
        </div>
        <div class="energybar fright">
        
        <div class="fleft">
            <label for="energybar_hours"><?php echo __("ENERGYLEVEL_HOURSWEEK")?></label>
            <span id="energybar_hours" class="fleft" rel="<?php echo $energyhours ?>"><?php echo $energyhours ?></span>
            <span class="jQbutton fright" id="save_energy" style="display: none;">Save</span>
        </div>
        <div class="energy_def fleft">
            <div id="slider-horizontal" style="height:12px; width:250px"></div>
            <label class="fleft" id="lbl1" style="color: blue"><?php echo __("LOW")?></label><span class="fleft">|</span>
            <label class="fleft" id="lbl2" style="color: green"><?php echo __("MEDIUM")?></label><span class="fleft">|</span>
            <label class="fleft" id="lbl3" style="color: red"><?php echo __("HIGH")?></label>
        </div>
        <div class="clear"></div>
        </div>




    </div>
</div>

<script>
    $(function() {
        $("#slider-horizontal").slider({
            orientation: "horizontal",
            range: "min",
            min: 0,
            max: 60,
            value: <?php echo $energyhours ?>,
            step: 0.5,
            slide: function(event, ui) {
                $("#energybar_hours").html(ui.value);
            },
            change: function(event,ui){
                energy_slider_change(event, ui);
            }

        });
        $("#energybar_hours").html($("#slider-horizontal").slider("value"));

    
    });

</script>