from scipy.stats import multivariate_normal
import numpy as np
from pprint import pprint as pprint
import io
import sys
import json
import re

## Expectation Maximization with Gaussian Mixture Models
## Micah Demong
##
## The mathematical formulas used in this code are 
## adapted from an online lecture by Alexander Ihler:
## "Gaussian Mixture Models and EM"
## https://youtu.be/qMTuMa86NzU
##
## Suggestions for the stopping criteria found in:
## "Analysis of stopping critera for the EM algorithm", Abbi et al.


# NOTE: To run this code, you may need to run: 
#       `pip install scipy`
#       `pip install numpy` 
#       if you have not already installed numpy and scipy.
# I'm using numpy v1.17 and scipy v1.3.3

# When using numeric values, it is recommended to use numpy arrays for efficiency. 
# See https://stackoverflow.com/a/994010
# One drawback of this is that we have to explicitly define array size during initialization,
# rather than having dynamically changing array size.

# In numpy: it is no longer recommended to use numpy.matrix, even for linear algebra.
# Just use regular arrays.
# https://docs.scipy.org/doc/numpy/reference/generated/numpy.matrix.html

# TODO: make sure dimensions are consistent.
# TODO: clean up print statements

# This function takes input from PHP and converts it to a convenient format
def input_to_array(str):
    return np.genfromtxt(io.StringIO(str), delimiter=' ')


# Performs the Expectation Maximization algorithm as described in:
# Clustering for malware classification; Pai et al. (2016)
# 
def expectation_maximization(k, points, distributions=[]):
    # Initialize parameters (mean, variance)

    # Converting list of points to be a matrix (np.ndarray)
    points = np.vstack(points)

    mins = []

    # I'm using standard python lists for distributions;
    # since distribution objects aren't numbers, they can't be put in numpy arrays.
    if(distributions == []):
        distributions = init_random_distributions(k, points)

    # We're using means as a heuristic to know when to stop
    old_means = get_means(distributions)

    # Using an arbitrary multiplier to ensure we enter loop
    # (because python doesn't have do-while loops)
    ARBITRARY_MULTIPLIER = 1.1
    new_means = [mean * ARBITRARY_MULTIPLIER for mean in old_means]

    # Probability matrix for each data point in each cluster.
    prob_mtx = np.zeros((len(points), k))

    MAX_ITERATION = 200
    iteration = 0

    # Alternate between E and M step until change is negligable
    while(significant_mean_change(old_means, new_means)):
        old_means = new_means
        iteration += 1
        # print("Starting iteration ", iteration)

        # E step: Compute probabilities needed in M step, based on
          # current estimates of the distribution parameters
        prob_mtx = expectation(distributions, points)

        # M Step: Use the probabilities from the E step to recompute
          # the distribution parameters, based on maximum likelihood estimators
        distributions = maximization(prob_mtx, points)

        new_means = get_means(distributions)

    
    print("Took ", iteration, " iterations.")
    table = np.concatenate((points, prob_mtx), axis=1)
    return {'dists':distributions, 'table':table}


# Using mean with difference 1e-6 as suggested in:
# "Analysis of stopping critera for the EM algorithm", Abbi et al.
#
# Using this for simplicity of implementation, even though using variance 
# would be a more accurate heuristic.
def significant_mean_change(old_means, new_means):

    MINIMUM_CHANGE = 1e-8

    for i, _ in enumerate(old_means):
        normalized_diff = abs(sum((old_means[i] - new_means[i]) / old_means[i]))
        if normalized_diff > MINIMUM_CHANGE:
            return True

    # If we get here, all of our diffs are small
    return False


def get_means(dist_list): 
    return [dist['mean'] for dist in dist_list]


def init_random_distributions(count, points):
    # TODO: this function could be improved, perhaps by random sampling

    dimension = len(points[0])
    # print(dimension)

    # gives an array [x_1-avg, x_2-avg, ..., x_n-avg]
    point_avg = np.mean(points, axis=0)

    # This selection of point_avg / 4 is a bit arbitrary.
    MAX_AVG_PERTURBATION = point_avg / 4
    
    # This selection is also kind of arbitrary
    MAX_RAND_COV_ARR = point_avg / 4

    # Results in an n x n covariance matrix
    # MAX_RANDOM_COV = MAX_RAND_COV_ARR * np.eye(dimension)
    # cov = np.cov(points)

    
    # INIT_COV = np.eye(dimension) 

    # MIN_COV = np.eye(dimension) * 1e-12

    dists = []

    for i in range(count):
        new_dist = dict()
        new_dist['mean'] = point_avg + (np.random.default_rng().random(size=dimension) * MAX_AVG_PERTURBATION)

        # Random covariance defined by https://stackoverflow.com/a/619406
        # tempcov = (np.random.default_rng().random(size=(dimension, dimension))) * MAX_RAND_COV_ARR
        # tempcov = np.cov(np.random.default_rng().random(size=(dimension, dimension)))
        # new_dist['cov'] = tempcov * np.transpose(tempcov)
        new_dist['cov'] = np.cov(np.transpose(points))
        # print(new_dist['cov'])

        new_dist['weight'] = 1 / count
        dists.append(new_dist)
    return dists


# Using the cluster information, computes an m x k probability matrix
# where m is the size of the data, k is the size of the clusters
def expectation(distributions, points):
    prob_mtx = np.zeros((len(points), len(distributions)))
    for k, cluster in enumerate(distributions):
        for m, point in enumerate(points):
            prob_mtx[m][k] = point_cluster_probability(point, cluster, distributions)
    return prob_mtx


def point_cluster_probability(point, cluster, distributions):

    if(len(distributions) == 0):
        raise ValueError("There must be at least one distribution")

    num = cluster['weight'] * multivariate_normal.logpdf(point, mean=cluster['mean'], cov=cluster['cov'])
    denom = 0

    for dist in distributions:
        denom += dist['weight'] * multivariate_normal.logpdf(point, mean=dist['mean'], cov=dist['cov'])

    if(denom == 0): return 0

    return (num / denom)


def maximization(prob_mtx, points):
    k = len(prob_mtx[0])
    dists = []

    # vector value: total responsibility of each cluster
    responsibilities = np.sum(prob_mtx, axis=0)
    # scalar value: sum of all total responsibilities
    total_resp = np.sum(responsibilities)


    for i in range(k):
        resp = responsibilities[i]
        new_dist = dict()
        new_dist['weight'] = resp / total_resp
        new_dist['mean'] = maximize_mean(resp, prob_mtx, i, points)
        new_dist['cov'] = maximize_cov(resp, prob_mtx, i, points)

        dists.append(new_dist)

    return dists


def maximize_mean(resp, prob_mtx, i, points):
    weights=prob_mtx[:,i]
    return np.average(points, axis=0, weights=weights)


def maximize_cov(resp, prob_mtx, i, points):
    # k = len(points[0])
    # weights = prob_mtx[:,i]

    # sum = np.zeros((k,k))
    # for j, weight in enumerate(weights):
    #     diff = (points[j] - mean)
    #     sum = sum + weight * np.transpose(diff) * diff

    # EPS = 10e-6
    # result = np.divide(sum, resp)
    # result = result + EPS * np.identity(result.shape[1])
    
    # return result
    EPS = 10e-6
    weights = prob_mtx[:,i]
    return (np.cov(points, rowvar=False, aweights=weights) + EPS)
    # return np.average(np.outer(diff, diff), axis=0, weights=prob_mtx[:,i]) / resp

# From https://stackoverflow.com/a/47626762
class NumpyEncoder(json.JSONEncoder):
    def default(self, obj):
        if isinstance(obj, np.ndarray):
            return obj.tolist()
        return json.JSONEncoder.default(self, obj)


# From: https://stackoverflow.com/a/20725965
def is_json(myjson):
  try:
    json_object = json.loads(myjson)
  except ValueError as e:
    return False
  return True


if(is_json(sys.argv[1])): 
    json_obj = json.loads(sys.argv[1])
    dists = json_obj['dist']
    points = input_to_array(json_obj['points'])
    k = json_obj['dimension']
    result = expectation_maximization(num, pts, dists)
    print(json.dumps(result, cls=NumpyEncoder))
else: 
    text = sys.argv[1].split('Z')
    if(len(text) == 3):
        dim = int(text[1])
        num = int(text[2])
        replaced = re.sub(r'\\n', '\n', text[0])
        pts = input_to_array(replaced)
        # pprint(re.sub(r'\\n', '\n', text[0]))
        # pprint(pts)
        result = expectation_maximization(num, pts)
        print(json.dumps(result, cls=NumpyEncoder))
    else:
        print("The input values are too short: ", sys.argv[1])

sys.stdout.flush
sys.stdin.close
sys.stdout.close


