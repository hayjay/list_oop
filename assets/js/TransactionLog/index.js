$(document).ready(function () {
    init();
});
function getAllTransactionLog(element,type) {
    $("#clear_completed_link").hide();
    $("#taskTabs").find('.nav-link').removeClass('border border-todo-grey');
    element.addClass('border border-todo-grey');
    var url = './transactionlog/index';
    if(!isEmpty(type)){
        url += '/'+type;
    }
    LIST.ajaxLoadCallback(url,function (response) {
        if(!isEmpty(response)){
            if(!isEmpty(response) && response.status == 'success'){
                var data = buildTransactionLog(response.data);
                $("#show_below_arrow_in_task_form").show();
                $("#task_tabs").show();
                if(isEmpty(response.total)){
                    $("#task_tabs").hide();
                    $("#show_below_arrow_in_task_form").hide();
                    $("#taskList").hide();
                    removeShadow();

                }
                if(!isEmpty(response.total)){
                    if(response.total - response.pending > 0){
                        $("#clear_completed_link").show();
                    }
                    addBoxShadow();
                    $("#taskList").show();
                }
                $("#taskList").html(data.html);
            }else{
                if(!isEmpty(response.message)){
                    console.error(response.message);
                    toastr.error(response.message);
                }else{
                    console.error('Information not found.');
                }

            }
        }
    });
}
function buildTransactionLog(response) {
    var html = '';
    var total = 0;
    if(!isEmpty(response)){
        total = response.length;
        var completed_icon = '<img class="task-status-icon" alt="svgImg" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHg9IjBweCIgeT0iMHB4Igp3aWR0aD0iMzIiIGhlaWdodD0iMzIiCnZpZXdCb3g9IjAgMCAyMjYgMjI2IgpzdHlsZT0iIGZpbGw6IzAwMDAwMDsiPjxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0ibm9uemVybyIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIHN0cm9rZS1saW5lY2FwPSJidXR0IiBzdHJva2UtbGluZWpvaW49Im1pdGVyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHN0cm9rZS1kYXNoYXJyYXk9IiIgc3Ryb2tlLWRhc2hvZmZzZXQ9IjAiIGZvbnQtZmFtaWx5PSJub25lIiBmb250LXdlaWdodD0ibm9uZSIgZm9udC1zaXplPSJub25lIiB0ZXh0LWFuY2hvcj0ibm9uZSIgc3R5bGU9Im1peC1ibGVuZC1tb2RlOiBub3JtYWwiPjxwYXRoIGQ9Ik0wLDIyNnYtMjI2aDIyNnYyMjZ6IiBmaWxsPSJub25lIj48L3BhdGg+PGcgaWQ9IkxheWVyXzEiPjxwYXRoIGQ9Ik0xMTMsMTUuODkwNjNjLTUzLjYzMjAzLDAgLTk3LjEwOTM3LDQzLjQ3NzM1IC05Ny4xMDkzNyw5Ny4xMDkzOGMwLDUzLjYzMjAzIDQzLjQ3NzM1LDk3LjEwOTM4IDk3LjEwOTM4LDk3LjEwOTM4YzUzLjYzMjAzLDAgOTcuMTA5MzgsLTQzLjQ3NzM1IDk3LjEwOTM4LC05Ny4xMDkzN2MwLC01My42MzIwMyAtNDMuNDc3MzUsLTk3LjEwOTM3IC05Ny4xMDkzNywtOTcuMTA5Mzd6IiBmaWxsPSIjZmZmZmZmIj48L3BhdGg+PHBhdGggZD0iTTExMywyMTUuNDA2MjVjLTU2LjUsMCAtMTAyLjQwNjI1LC00NS45MDYyNSAtMTAyLjQwNjI1LC0xMDIuNDA2MjVjMCwtNTYuNSA0NS45MDYyNSwtMTAyLjQwNjI1IDEwMi40MDYyNSwtMTAyLjQwNjI1YzU2LjUsMCAxMDIuNDA2MjUsNDUuOTA2MjUgMTAyLjQwNjI1LDEwMi40MDYyNWMwLDU2LjUgLTQ1LjkwNjI1LDEwMi40MDYyNSAtMTAyLjQwNjI1LDEwMi40MDYyNXpNMTEzLDIxLjE4NzVjLTUwLjY3MzQ0LDAgLTkxLjgxMjUsNDEuMTM5MDYgLTkxLjgxMjUsOTEuODEyNWMwLDUwLjY3MzQ0IDQxLjEzOTA2LDkxLjgxMjUgOTEuODEyNSw5MS44MTI1YzUwLjY3MzQ0LDAgOTEuODEyNSwtNDEuMTM5MDYgOTEuODEyNSwtOTEuODEyNWMwLC01MC42NzM0NCAtNDEuMTM5MDYsLTkxLjgxMjUgLTkxLjgxMjUsLTkxLjgxMjV6IiBmaWxsPSIjY2NjY2NjIj48L3BhdGg+PHBhdGggZD0iTTEwOS40Njg3NSwxMzkuNDg0Mzh2MGMtMS40MTI1LDAgLTIuODI1LC0wLjcwNjI1IC0zLjg4NDM4LC0xLjc2NTYybC0yMy4xMjk2OSwtMjQuNzE4NzVjLTEuOTQyMTksLTIuMTE4NzUgLTEuOTQyMTksLTUuNDczNDQgMC4zNTMxMywtNy40MTU2M2MyLjExODc1LC0xLjk0MjE5IDUuNDczNDQsLTEuOTQyMTkgNy40MTU2MywwLjM1MzEzbDE5LjI0NTMxLDIwLjQ4MTI1bDM2LjkwMTU2LC0zOC40OTA2MmMxLjk0MjE5LC0yLjExODc1IDUuMjk2ODgsLTIuMTE4NzUgNy40MTU2MywtMC4xNzY1NmMyLjExODc1LDEuOTQyMTkgMi4xMTg3NSw1LjI5Njg4IDAuMTc2NTYsNy40MTU2M2wtNDAuNjA5MzcsNDIuNzI4MTJjLTEuMDU5MzgsMS4wNTkzOCAtMi40NzE4OCwxLjU4OTA2IC0zLjg4NDM4LDEuNTg5MDZ6IiBmaWxsPSIjMWFiYzljIj48L3BhdGg+PC9nPjwvZz48L3N2Zz4="/>';
        for(var i = 0;i < total;i++ ){
            html +='<div class="row task-item" title="Activity : '+response[i].description+'">';
            html +=     '<div class=" input-group-prepend border-white">';
            html +=         '<div class="input-group-text bg-white border-white text-light">';
            html +=         '</div>';
            html +=     '</div>';
            html +=     '<div class="col-9 form-control-lg todo-title-div">';
            html +=             ('<span class="text-dark todo-title" onclick="editTitle($(this),'+response[i].id+')">'+response[i].description+'</span>');
            html +=     '</div>';
            html +=     '<div class="col-1 float-right mt-2"><span class="float-right task_cancel text-white"><i class="fa fa-2x fa-times" onclick="deleteList('+response[i].id+')"></i></span></div> ';
            html +='</div>';
            // html +='<hr>';
        }
    }
    return {
        'html' : html, 'total' : total
    };
}
function init() {
    $("#taskTabs").find('.border-todo-grey').trigger('click');
}
function addBoxShadow() {
    var shadow = "white 0 10px 0 -5px,#f0f2f4 0 12px 0px -5px,white 0 22px 0 -10px,#f0f2f4 0 24px 0px -10px";
    $("#todo-container").css( {"box-shadow":shadow});
    $("#todo-container").addClass( "border-bottom-task-list");
}