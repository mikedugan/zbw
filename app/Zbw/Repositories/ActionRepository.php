<?php namespace Zbw\Repositories;

class ActionRepository {
	protected $action;
	public function __construct($action = false)
	{
		$this->action = $action ? \ActionRequired::find($action) : null;
	}

	public static function all()
	{
		return \ActionRequired::all();
	}

	public static function getResolved()
	{
		return \ActionRequired::where('resolved', '=', 1);
	}

	public static function getUnresolved()
	{
		return \ActionRequired::where('resolved', '=', 0);
	}

	public static function getByCid($cid)
	{
		return \ActionRequired::where('cid', '=', $cid);
	}

	public static function getResolvedByCid($cid)
	{
		return \ActionRequired::where('cid', '=', $cid);
	}

	public static function search($query)
	{
		return \ActionRequired::where('title', 'LIKE', "%$query%")->orWhere('description', 'LIKE', "%$query%");
	}

	public static function getRecent($num)
	{
		return \ActionRequired::all()->sortBy('created_at')->limit($num);
	}

	public function resolve()
	{
		$this->action->resolved = 1;
		$this->action->resolved_by = Auth::user()->cid;
		return $this->action->save();
	}

	public function unresolve()
	{
		$this->action->resolved = 0;
		$this->action->resolved_by = null;
		return $this->action->save();
	}
}