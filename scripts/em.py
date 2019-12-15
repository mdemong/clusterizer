from scipy.stats import multivariate_normal
import numpy as np
from pprint import pprint as pprint
# NOTE: To run this code, you may need to run: 
#       `pip install scipy`
#       `pip install numpy` 
#       if you have not already installed numpy and scipy.
# I'm using numpy v1.17.

# When using numeric values, it is recommended to use numpy arrays for efficiency. 
# See https://stackoverflow.com/a/994010
# One drawback of this is that we have to explicitly define array size during initialization,
# rather than having dynamically changing array size.

# In numpy: it is no longer recommended to use numpy.matrix, even for linear algebra.
# Just use regular arrays.
# https://docs.scipy.org/doc/numpy/reference/generated/numpy.matrix.html

# TODO: make sure dimensions are consistent.

# TODO: define function signature
# This function takes input from PHP and converts it to a convenient format
def read_input():

    
    # Assuming 2 distributions (i.e. binary classification)
    DIST_COUNT = 2
    # TODO: actual data input from PHP
    temp_points = np.array(1, 2, 3)

    expectation_maximization(DIST_COUNT, temp_points)


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

    old_means = get_means(distributions)

    # Using an arbitrary multiplier to ensure we enter loop
    # (because python doesn't have do-while loops)
    ARBITRARY_MULTIPLIER = 1.1
    new_means = [mean * ARBITRARY_MULTIPLIER for mean in old_means]

    # Alternate between E and M step until change is negligable
    while(significant_mean_change(old_means, new_means)):
        old_means = new_means
        # TODO: modify 'changed' based on exp. and max. function outputs

        # E step: Compute probabilities needed in M step, based on
          # current estimates of the distribution parameters
        prob_mtx = expectation(distributions, points)

        # M Step: Use the probabilities from the E step to recompute
          # the distribution parameters, based on 
          # maximum likelihood estimators
        maximization()
        new_means = get_means(distributions)
    return []

# Using mean with difference 1e-6 as suggested in:
# Analysis of stopping critera for the EM algorithm, Abbi et al.
#
# Using this for simplicity of implementation, even though using variance 
# would be a more accurate heuristic.
#
#
def significant_mean_change(old_means, new_means):

    MINIMUM_CHANGE = 1e-6

    for i, _ in enumerate(old_means):
        normalized_diff = abs(sum((old_means[i] - new_means[i]) / old_means[i]))
        if normalized_diff > MINIMUM_CHANGE:
            return True

    # If we get here, all of our diffs are small
    return False


def get_means(dist_list): 
    return [dist.means() for dist in dist_list]


def init_random_distributions(count, points):

    # TODO: this could be improved, perhaps by random sampling

    # gives an array [x_1-avg, x_2-avg, ..., x_n-avg]
    point_avg = np.mean(points, axis=0)

    # This selection of point_avg / 4 is a bit arbitrary.
    MAX_AVG_PERTURBATION = point_avg / 4
    
    # This selection of point avg / 2 is also kind of arbitrary
    MAX_RAND_COV_ARR = MAX_AVG_PERTURBATION / 2

    # Results in an n x n covariance matrix
    MAX_RANDOM_COV = np.transpose(MAX_RAND_COV_ARR) * MAX_RAND_COV_ARR

    dists = []
    dimension = len(point_avg)

    for i in range(count):
        new_dist = dict()
        new_dist['mean'] = point_avg + (np.random.default_rng().random(size=dimension) * MAX_AVG_PERTURBATION)

        new_dist['cv'] = (np.random.default_rng().random(size=(dimension, dimension)) * MAX_RANDOM_COV)

        dists.append(new_dist)
    return dists


# Using the cluster information, computes an m x k probability matrix
# where m is the size of the data, k is the size of the clusters
def expectation(distributions, points):
    prob_mtx = np.zeros(len(points), len(distributions))
    # TODO: fill in the formula
    return prob_mtx


# TODO: define function signature
def maximization():
    return




# TODO: Create function to convert numpy arrays to json-serializable python lists