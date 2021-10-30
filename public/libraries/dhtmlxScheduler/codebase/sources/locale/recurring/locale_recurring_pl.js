/*
@license
dhtmlxScheduler v.5.1.6 Stardard

This software is covered by GPL license. You also can obtain Commercial or Enterprise license to use it in non-GPL project - please contact sales@dhtmlx.com. Usage without proper license is prohibited.

(c) Dinamenta, UAB.
*/
scheduler.__recurring_template='<div class="dhx_form_repeat"> <form> <div class="dhx_repeat_left"> <label><input class="dhx_repeat_radio" type="radio" name="repeat" value="day" />Codziennie</label><br /> <label><input class="dhx_repeat_radio" type="radio" name="repeat" value="week"/>Co tydzie</label><br /> <label><input class="dhx_repeat_radio" type="radio" name="repeat" value="month" checked />Co miesic</label><br /> <label><input class="dhx_repeat_radio" type="radio" name="repeat" value="year" />Co rok</label> </div> <div class="dhx_repeat_divider"></div> <div class="dhx_repeat_center"> <div style="display:none;" id="dhx_repeat_day"> <label><input class="dhx_repeat_radio" type="radio" name="day_type" value="d"/>Kadego</label><input class="dhx_repeat_text" type="text" name="day_count" value="1" />dnia<br /> <label><input class="dhx_repeat_radio" type="radio" name="day_type" checked value="w"/>Kadego dnia roboczego</label> </div> <div style="display:none;" id="dhx_repeat_week"> Powtarzaj kadego<input class="dhx_repeat_text" type="text" name="week_count" value="1" />tygodnia w dni:<br /> <table class="dhx_repeat_days"> <tr> <td> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="1" />Poniedziaek</label><br /> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="4" />Czwartek</label> </td> <td> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="2" />Wtorek</label><br /> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="5" />Pitek</label> </td> <td> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="3" />roda</label><br /> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="6" />Sobota</label> </td> <td> <label><input class="dhx_repeat_checkbox" type="checkbox" name="week_day" value="0" />Niedziela</label><br /><br /> </td> </tr> </table> </div> <div id="dhx_repeat_month"> <label><input class="dhx_repeat_radio" type="radio" name="month_type" value="d"/>Powtrz</label><input class="dhx_repeat_text" type="text" name="month_day" value="1" />dnia kadego<input class="dhx_repeat_text" type="text" name="month_count" value="1" />miesica<br /> <label><input class="dhx_repeat_radio" type="radio" name="month_type" checked value="w"/>W</label><input class="dhx_repeat_text" type="text" name="month_week2" value="1" /><select name="month_day2"><option value="1" selected >Poniedziaek<option value="2">Wtorek<option value="3">roda<option value="4">Czwartek<option value="5">Pitek<option value="6">Sobota<option value="0">Niedziela</select>kadego<input class="dhx_repeat_text" type="text" name="month_count2" value="1" />miesica<br /> </div> <div style="display:none;" id="dhx_repeat_year"> <label><input class="dhx_repeat_radio" type="radio" name="year_type" value="d"/>Kadego</label><input class="dhx_repeat_text" type="text" name="year_day" value="1" />dnia miesica<select name="year_month"><option value="0" selected >Stycznia<option value="1">Lutego<option value="2">Marca<option value="3">Kwietnia<option value="4">Maja<option value="5">Czerwca<option value="6">Lipca<option value="7">Sierpnia<option value="8">Wrzenia<option value="9">Padziernka<option value="10">Listopada<option value="11">Grudnia</select><br /> <label><input class="dhx_repeat_radio" type="radio" name="year_type" checked value="w"/>W</label><input class="dhx_repeat_text" type="text" name="year_week2" value="1" /><select name="year_day2"><option value="1" selected >Poniedziaek<option value="2">Wtorek<option value="3">rod<option value="4">Czwartek<option value="5">Pitek<option value="6">Sobot<option value="7">Niedziel</select>miesica<select name="year_month2"><option value="0" selected >Stycznia<option value="1">Lutego<option value="2">Marca<option value="3">Kwietnia<option value="4">Maja<option value="5">Czerwca<option value="6">Lipca<option value="7">Sierpnia<option value="8">Wrzenia<option value="9">Padziernka<option value="10">Listopada<option value="11">Grudnia</select><br /> </div> </div> <div class="dhx_repeat_divider"></div> <div class="dhx_repeat_right"> <label><input class="dhx_repeat_radio" type="radio" name="end" checked/>Bez daty kocowej</label><br /> <label><input class="dhx_repeat_radio" type="radio" name="end" />Po</label><input class="dhx_repeat_text" type="text" name="occurences_count" value="1" />wystpieniu/ach<br /> <label><input class="dhx_repeat_radio" type="radio" name="end" />Zakocz w</label><input class="dhx_repeat_date" type="text" name="date_of_end" value="'+scheduler.config.repeat_date_of_end+'" /><br /> </div> </form> </div> <div style="clear:both"> </div>';

