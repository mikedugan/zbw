var trainingSession = new Object();
trainingSession.reviews = new Object();
trainingSession.score = 0;
trainingSession.markups = new Object();
trainingSession.markdowns = new Object();
trainingSession.timer = { start: 0, live: 0, debrief: 0, complete: 0 };
trainingSession.conditions = { weather: 0, complexity: 0, traffic: 0};
trainingSession.reviewTopic = {
    brief: '',
    runway: '',
    weather: '',
    coordination: '',
    phraseology: '',
    priority: '',
    flow: '',
    identity: '',
    separation: '',
    pointouts: '',
    knowledge: '',
    loa: ''
};

trainingSession.countedTopics = 0;
trainingSession.performanceTopics = {
    brief: -1,
    runway: -1,
    weather: -1,
    coordination: -1,
    phraseology: -1,
    priority: -1,
    flow: -1,
    identity: -1,
    separation: -1,
    pointouts: -1,
    airspace: -1,
    loa: -1
};

trainingSession.markdowns = {
    wafdof: 0,
    squawk: 0,
    cl_late: 0,
    cl_wrong: 0,
    taxi: 0,
    landing: 0,
    takeoff: 0,
    luaw: 0,
    waketurb: 0,
    cl_approach: 0,
    mva: 0,
    sop: 0,
    fix: 0,
    final: 0,
    flow: 0,
    separation: 0,
    phraseology: 0,
    near_incident: 0,
    incident: 0,
    coordination: 0,
    readback: 0
};
trainingSession.markups = {
    flow: 0,
    separation: 0,
    phraseology: 0,
    situation: 0,
    pointouts: 0,
    sequencing: 0
};

$('.markdown').click(
  function (e)
  {
      e.preventDefault();
      var $this = $(this);
      var points = $this.data('points');
      var attr = $this.attr('id');
      attr = attr.split('-')[1];
      trainingSession.markdowns[attr] = points;
  }
);

$('.markup').click(
  function (e)
  {
      e.preventDefault();
      var $this = $(this);
      var points = $this.data('points');
      var attr = $this.attr('id');
      attr = attr.split('-')[1];
      trainingSession.markups[attr] = points;
  }
);

$('.reviewbox').click(
  function (e)
  {
      var $this = $(this);
      var subject = $this.data('subject');
      var topic = $this.attr('id').split('-')[1];
      if ($this.prop('checked')) {
          trainingSession.reviewTopic[topic] = subject;
      }
      else {
          trainingSession.reviewTopic[topic] = '';
      }
  }
);

$('.performance').change(
  function (e)
  {
      var $this = $(this);
      var attr = $this.attr('id');
      var val = $this.val();
      var points = 0;
      if (val === 'na') {
          points = -1;
      }
      else if (val === 'u') {
              points = 0;
          }
      else if (val === 'n') {
              points = 5;
          }
      else if (val === 's') {
              points = 10;
          }
      var origPoints = trainingSession.performanceTopics[attr];
      if (origPoints === -1 && points > -1) {
          trainingSession.countedTopics++;
      }
      else {
          if (origPoints > -1 && points === -1) {
              trainingSession.countedTopics--;
          }
      }
      trainingSession.performanceTopics[attr] = points;
  }
);

$('.condition').change(function(e) {
    var $this = $(this);
    var adjustment = $this.children('option:selected').data('points');
    var attr = $this.attr('id').split('-')[1];
    trainingSession.conditions[attr] = adjustment;
});

$('#start').click(
  function (e)
  {
      e.preventDefault();
      console.log(trainingSession);
  }
);

$('.timer').click(function(e) {
    e.preventDefault();
    var $this = $(this);
    var timer = $this.data('timer');
    time = new Date();
    trainingSession.timer[timer] = time;
});

$('#update-score').click(function(e) {
    e.preventDefault();
    var score = getPerformanceScore();
    var marks = getMarkDifferential();
    $('.score').replaceWith('<div class="score"><button class="btn btn-block">'+adjustScore(score, marks)+'</button></div>');
});

function adjustScore(score)
{
    var markup = getMarkDifferential();
    var adjustment = 0;
    for(var adj in trainingSession.conditions) {
        adjustment += trainingSession.conditions[adj];
    }
    adjustment = 1 - (adjustment * 0.01);
    newMax = score[1] * adjustment;
    newScore = score[0] + markup[0] + markup[1];
    if(newMax <= 0) newMax = 1;
    if(newScore <= 0) newScore = 0;
    trainingSession.score = Math.round((newScore / newMax * 100) * 100) / 100;
    if(trainingSession.score > 100) { trainingSession.score = 100; }
    return trainingSession.score + '%';
}

function getPerformanceScore()
{
    var max = trainingSession.countedTopics * 10;
    var score = 0;
    for(var subject in trainingSession.performanceTopics) {
        if(trainingSession.performanceTopics[subject] >= 0) {
            score += trainingSession.performanceTopics[subject];
        }
    }
    return [score, max];
}

function getMarkDifferential()
{
    var up = 0;
    var down = 0;
    for(var mark in trainingSession.markups) {
        up += trainingSession.markups[mark];
    }
    for(var mark in trainingSession.markdowns) {
        down -= trainingSession.markdowns[mark];
    }
    return [up, down];
}

function checkGrade()
{
    if(trainingSession.score < 70) { $('.score button').addClass('btn-danger'); }
    else if (trainingSession.score < 85) { $('.score button').addClass('btn-warning'); }
    else if (trainingSession.score > 95) { $('.score button').addClass('btn-success'); }

}

function update()
{
    $('#update-score').trigger('click');
    checkGrade();
}

$(function()
{
    var t = window.setInterval(update, 1000);
});
