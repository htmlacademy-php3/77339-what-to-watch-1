<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JobBatch
 *
 * @package App\Models
 * @property string $id
 * @property string $name
 * @property int $total_jobs
 * @property int $pending_jobs
 * @property int $failed_jobs
 * @property string $failed_job_ids
 * @property string|null $options
 * @property int|null $cancelled_at
 * @property int $created_at
 * @property int|null $finished_at
 * @method static Builder<static>|JobBatch newModelQuery()
 * @method static Builder<static>|JobBatch newQuery()
 * @method static Builder<static>|JobBatch query()
 * @method static Builder<static>|JobBatch whereCancelledAt($value)
 * @method static Builder<static>|JobBatch whereCreatedAt($value)
 * @method static Builder<static>|JobBatch whereFailedJobIds($value)
 * @method static Builder<static>|JobBatch whereFailedJobs($value)
 * @method static Builder<static>|JobBatch whereFinishedAt($value)
 * @method static Builder<static>|JobBatch whereId($value)
 * @method static Builder<static>|JobBatch whereName($value)
 * @method static Builder<static>|JobBatch whereOptions($value)
 * @method static Builder<static>|JobBatch wherePendingJobs($value)
 * @method static Builder<static>|JobBatch whereTotalJobs($value)
 * @mixin \Eloquent
 */
class JobBatch extends Model
{
	protected $table = 'job_batches';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'total_jobs' => 'int',
		'pending_jobs' => 'int',
		'failed_jobs' => 'int',
		'cancelled_at' => 'int',
		'finished_at' => 'int'
	];

	protected $fillable = [
		'name',
		'total_jobs',
		'pending_jobs',
		'failed_jobs',
		'failed_job_ids',
		'options',
		'cancelled_at',
		'finished_at'
	];
}
